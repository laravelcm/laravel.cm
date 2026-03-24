<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class() extends Migration
{
    public function up(): void
    {
        DB::table('articles')->where('id', 8)->update([
            'body' => DB::raw("
                REPLACE(
                REPLACE(
                REPLACE(
                REPLACE(body,
                    '[**Behance](behance.net)', '[**Behance](https://behance.net)'),
                    '[**Dribbble](dribbble.com)', '[**Dribbble](https://dribbble.com)'),
                    '[**Instagram](instagram.com)', '[**Instagram](https://instagram.com)'),
                    '[**Uplabs](uplabs.com)', '[**Uplabs](https://uplabs.com)')
            "),
        ]);

        DB::table('articles')->where('id', 82)->update([
            'body' => DB::raw("
                REPLACE(
                REPLACE(body,
                    '[Protailwind](protailwind.com)', '[Protailwind](https://protailwind.com)'),
                    '[TailwindUi](tailwindui.com)', '[TailwindUi](https://tailwindui.com)')
            "),
        ]);

        DB::table('articles')->where('id', 81)->update([
            'body' => DB::raw("
                REPLACE(body,
                    '[railway.app/pricing](railway)', '[railway.app/pricing](https://railway.app/pricing)')
            "),
        ]);

        DB::table('articles')->where('id', 55)->update([
            'body' => DB::raw("
                REPLACE(body,
                    '[Slack](https://laravel.cm/slack)', '[Discord](https://laravel.cm/discord)')
            "),
        ]);

        DB::table('articles')->whereIn('id', [107, 136])->update([
            'canonical_url' => null,
        ]);

        DB::table('discussions')->where('id', 21)->update([
            'body' => DB::raw("
                REPLACE(
                REPLACE(body,
                    '[1911.PNG](Uploading...)', ''),
                    '![1912.PNG](Uploading...)', '')
            "),
        ]);
    }
};
