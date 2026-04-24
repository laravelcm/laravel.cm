<?php

declare(strict_types=1);

namespace App\Console\Commands\Content;

use App\Actions\User\BanUserAction;
use App\Console\Commands\Content\Data\AttackerReport;
use App\Models\Article;
use App\Models\Discussion;
use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/**
 * Audit permanent : détecte tout contenu pollué par un lien vers un fichier
 * dangereux hébergé sur le bucket S3 (ex: .html, .php, .svg avec script, etc).
 *
 * Utilisation standard :
 *   php artisan content:audit-malicious
 *
 * Pendant un incident, si tu as identifié des filenames précis (comme ceux
 * du webshell du 2026-01-09 : 1iuZviz0Bxpb3F9ZdyYmXuCobSO9XHax1AQbP8Xf et
 * 72F15MzGP8TgCTT89TLZnxeO70aSfb2c8iDUErLv), passe-les via --filenames :
 *   php artisan content:audit-malicious --filenames=1iuZviz0Bxpb...,72F15MzGP8...
 */
final class AuditMaliciousContentCommand extends Command
{
    /**
     * Extensions considérées comme dangereuses si trouvées dans un lien S3.
     *
     * @var array<int, string>
     */
    private const array DEFAULT_DANGEROUS_EXTENSIONS = [
        'html', 'htm', 'xhtml', 'shtml',
        'svg', 'xml',
        'js', 'wasm', 'jar',
        'php', 'phtml', 'phar',
        'exe', 'dll', 'msi',
        'sh', 'bat', 'cmd', 'ps1', 'vbs',
        'jsp', 'asp', 'aspx',
    ];

    /** @var array<int, class-string<Model>> */
    private const array MODELS = [
        Article::class,
        Thread::class,
        Discussion::class,
        Reply::class,
    ];

    private const string BAN_REASON = 'Upload de contenu malveillant';

    protected $signature = 'content:audit-malicious
        {--fix : Nettoie les liens malveillants dans le body (destructif, en transaction)}
        {--ban : Bannit automatiquement les users auteurs de contenu malveillant}
        {--extensions= : Liste CSV des extensions à flagger (override la liste par défaut)}
        {--filenames= : Liste CSV de filenames spécifiques à chercher en plus (ex: pendant un incident)}
        {--domain=laravelcm.s3 : Domaine S3 à surveiller (partial match)}';

    protected $description = 'Scanne articles/threads/discussions/replies pour liens malveillants vers S3 et liste les users attaquants';

    public function handle(): int
    {
        $fix = (bool) $this->option('fix');
        $ban = (bool) $this->option('ban');

        $this->info('🔍 Audit du contenu malveillant — '.now()->toDateTimeString());
        $this->displayAuditConfig();
        $this->newLine();

        $counts = $this->countPolluted();

        if (array_sum($counts) === 0) {
            $this->info('✅ Aucun contenu malveillant détecté dans la base.');

            return self::SUCCESS;
        }

        $this->renderCountsTable($counts);
        $this->newLine();

        $attackers = $this->identifyAttackers();

        $this->renderAttackersTable($attackers);
        $this->newLine();

        if (! $fix && ! $ban) {
            $this->warn('ℹ️  Mode analyse uniquement (dry-run). Relance avec --fix et/ou --ban pour agir.');

            return self::SUCCESS;
        }

        if ($fix) {
            $this->cleanupContent();
        }

        if ($ban) {
            $this->banAttackers($attackers);
        }

        return self::SUCCESS;
    }

    /**
     * Construit le regex de détection (extensions dangereuses + filenames custom).
     */
    private function suspiciousPattern(): string
    {
        $domain = preg_quote((string) $this->option('domain'), '/');
        $extensions = implode('|', $this->resolveExtensions());

        $pattern = sprintf('(%s\.[^) \s]+\.(%s))', $domain, $extensions);

        $filenames = $this->resolveFilenames();
        if ($filenames !== []) {
            $escaped = array_map(fn (string $name): string => preg_quote($name, '/'), $filenames);
            $pattern .= '|('.implode('|', $escaped).')';
        }

        return $pattern;
    }

    /**
     * Construit le regex de cleanup (retire les markdown links malveillants).
     */
    private function cleanupPattern(): string
    {
        return '!?\[[^\]]*\]\(https?://[^)]*('.$this->suspiciousPattern().')[^)]*\)';
    }

    /**
     * @return array<int, string>
     */
    private function resolveExtensions(): array
    {
        $custom = (string) $this->option('extensions');

        if ($custom === '') {
            return self::DEFAULT_DANGEROUS_EXTENSIONS;
        }

        return array_values(array_filter(array_map(mb_trim(...), explode(',', $custom))));
    }

    /**
     * @return array<int, string>
     */
    private function resolveFilenames(): array
    {
        $custom = (string) $this->option('filenames');

        if ($custom === '') {
            return [];
        }

        return array_values(array_filter(array_map(mb_trim(...), explode(',', $custom))));
    }

    private function displayAuditConfig(): void
    {
        $extensions = $this->resolveExtensions();
        $filenames = $this->resolveFilenames();

        $this->line(sprintf(
            ' - Domaine surveillé : <info>%s</info>',
            (string) $this->option('domain'),
        ));
        $this->line(sprintf(
            ' - Extensions flaggées (%d) : <info>%s</info>',
            count($extensions),
            implode(', ', $extensions),
        ));

        if ($filenames !== []) {
            $this->line(sprintf(
                ' - Filenames spécifiques (%d) : <info>%s</info>',
                count($filenames),
                implode(', ', $filenames),
            ));
        }
    }

    /**
     * @return array<string, int>
     */
    private function countPolluted(): array
    {
        $counts = [];

        foreach (self::MODELS as $class) {
            $counts[class_basename($class)] = $this->scopedQuery($class)->count();
        }

        return $counts;
    }

    /**
     * @return Collection<int, AttackerReport>
     */
    private function identifyAttackers(): Collection
    {
        /** @var Collection<int, int> $userIds */
        $userIds = collect();

        foreach (self::MODELS as $class) {
            /** @var Collection<int, int> $ids */
            $ids = $this->scopedQuery($class)->pluck('user_id')->filter();
            $userIds = $userIds->merge($ids);
        }

        $uniqueUserIds = $userIds->unique()->values();

        if ($uniqueUserIds->isEmpty()) {
            return collect();
        }

        $users = User::query()
            ->whereIn('id', $uniqueUserIds)
            ->get(['id', 'username', 'email', 'banned_at']);

        return $users
            ->map(function (User $user): AttackerReport {
                $perTable = [];
                $total = 0;

                foreach (self::MODELS as $class) {
                    $count = $this->scopedQuery($class)->where('user_id', $user->id)->count();
                    if ($count > 0) {
                        $perTable[] = class_basename($class).':'.$count;
                        $total += $count;
                    }
                }

                return new AttackerReport(
                    id: $user->id,
                    username: $user->username,
                    email: $user->email,
                    bannedAt: $user->banned_at?->format('Y-m-d'),
                    pollutedCount: $total,
                    tables: implode(', ', $perTable),
                );
            })
            ->sortByDesc('pollutedCount')
            ->values()
            ->toBase();
    }

    private function cleanupContent(): void
    {
        if (! $this->confirm('⚠️  Confirmer le nettoyage destructif des liens malveillants dans le body ?', default: false)) {
            $this->warn('Nettoyage annulé.');

            return;
        }

        $this->info('🧹 Nettoyage en transaction...');

        $detectionPattern = $this->suspiciousPattern();
        $cleanupPattern = $this->cleanupPattern();

        DB::transaction(function () use ($detectionPattern, $cleanupPattern): void {
            foreach (self::MODELS as $class) {
                $table = (new $class)->getTable();

                $affected = DB::update(
                    sprintf("UPDATE %s SET body = regexp_replace(body, ?, '', 'gi'), body_html = NULL, body_rendered_at = NULL WHERE body ~* ?", $table),
                    [$cleanupPattern, $detectionPattern],
                );

                $this->line(sprintf(' - %s: %d lignes mises à jour', class_basename($class), $affected));
            }
        });

        $this->info('✅ Nettoyage effectué. Relancez `php artisan content:rerender` pour régénérer le body_html.');
    }

    /**
     * @param  Collection<int, AttackerReport>  $attackers
     */
    private function banAttackers(Collection $attackers): void
    {
        if ($attackers->isEmpty()) {
            return;
        }

        if (! $this->confirm(sprintf('⚠️  Confirmer le bannissement de %d user(s) ?', $attackers->count()), default: false)) {
            $this->warn('Bannissement annulé.');

            return;
        }

        $banner = resolve(BanUserAction::class);
        $skipped = 0;

        foreach ($attackers as $attacker) {
            /** @var User|null $user */
            $user = User::query()->find($attacker->id);

            if (! $user instanceof User) {
                continue;
            }

            if ($user->banned_at !== null) {
                $this->line(sprintf(' - @%s déjà banni, skip', $user->username));
                $skipped++;

                continue;
            }

            $banner->execute($user, self::BAN_REASON);
            $this->line(sprintf(' - @%s banni (user_id=%d)', $user->username, $user->id));
        }

        $this->info(sprintf('✅ %d user(s) banni(s), %d déjà banni(s).', $attackers->count() - $skipped, $skipped));
    }

    /**
     * @param  class-string<Model>  $class
     * @return Builder<Model>
     */
    private function scopedQuery(string $class): Builder
    {
        return $class::query()->whereRaw('body ~* ?', [$this->suspiciousPattern()]);
    }

    /**
     * @param  array<string, int>  $counts
     */
    private function renderCountsTable(array $counts): void
    {
        $this->info('📊 Contenus pollués par table :');

        $this->table(
            headers: ['Table', 'Contenus pollués'],
            rows: collect($counts)
                ->map(fn (int $count, string $table): array => [$table, $count])
                ->values()
                ->all(),
        );
    }

    /**
     * @param  Collection<int, AttackerReport>  $attackers
     */
    private function renderAttackersTable(Collection $attackers): void
    {
        if ($attackers->isEmpty()) {
            return;
        }

        $this->info(sprintf('🎯 %d user(s) identifié(s) comme auteurs :', $attackers->count()));

        $this->table(
            headers: ['ID', 'Username', 'Email', 'Banni', '# pollués', 'Tables'],
            rows: $attackers->map(fn (AttackerReport $a): array => [
                $a->id,
                '@'.$a->username,
                $a->email,
                $a->bannedAt ?? '-',
                $a->pollutedCount,
                $a->tables,
            ])->all(),
        );
    }
}
