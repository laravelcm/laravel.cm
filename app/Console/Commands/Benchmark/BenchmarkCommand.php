<?php

declare(strict_types=1);

namespace App\Console\Commands\Benchmark;

use Illuminate\Console\Command;

final class BenchmarkCommand extends Command
{
    protected $signature = 'benchmark:blank-vs-empty';

    protected $description = 'Benchmark performance comparison between blank() and empty() functions';

    public function handle(): int
    {
        $this->displayHeader();
        $this->runBenchmarkTests();

        return Command::SUCCESS;
    }

    private function displayHeader(): void
    {
        $this->newLine();
        $this->line('<fg=white;bg=blue> Performance Benchmark: blank() vs empty() </fg=white;bg=blue>');
        $this->newLine();
    }

    private function runBenchmarkTests(): void
    {
        $testCases = $this->getTestCases();

        foreach ($testCases as $description => $value) {
            $this->line("<fg=cyan>Testing: {$description}</fg=cyan>");

            $blankMetrics = $this->measurePerformance(fn (): bool => blank($value));
            $emptyMetrics = $this->measurePerformance(fn (): bool => empty($value));

            $this->displayResults($blankMetrics, $emptyMetrics);
            $this->newLine();
        }
    }

    /**
     * @return array{time: float, memory: float}
     */
    private function measurePerformance(callable $callback): array
    {
        $iterations = 100000;

        $startTime = microtime(true);
        $startMemory = memory_get_usage(true);

        for ($i = 0; $i < $iterations; $i++) {
            $callback();
        }

        $endTime = microtime(true);
        $endMemory = memory_get_usage(true);

        return [
            'time' => $endTime - $startTime,
            'memory' => $endMemory - $startMemory,
        ];
    }

    /**
     * @param  array{time: float, memory: float}  $blankMetrics
     * @param  array{time: float, memory: float}  $emptyMetrics
     */
    private function displayResults(array $blankMetrics, array $emptyMetrics): void
    {
        $blankTime = $this->formatTime($blankMetrics['time']);
        $emptyTime = $this->formatTime($emptyMetrics['time']);

        $blankMemory = $this->formatMemory($blankMetrics['memory']);
        $emptyMemory = $this->formatMemory($emptyMetrics['memory']);

        $this->line(sprintf(
            'blank() <bg=blue;fg=black> TIME: %s </> <bg=yellow;fg=black> MEMORY: %s </>',
            $blankTime,
            $blankMemory
        ));

        $this->line(sprintf(
            'empty() <bg=blue;fg=black> TIME: %s </> <bg=yellow;fg=black> MEMORY: %s </>',
            $emptyTime,
            $emptyMemory
        ));

        $isFasterBlank = $blankMetrics['time'] < $emptyMetrics['time'];
        $ratio = $isFasterBlank
            ? round($emptyMetrics['time'] / $blankMetrics['time'], 2)
            : round($blankMetrics['time'] / $emptyMetrics['time'], 2);

        $winner = $isFasterBlank ? 'blank()' : 'empty()';
        $this->line("  <fg=bright-green>{$winner} is {$ratio}x faster</fg=bright-green>");
    }

    private function formatTime(float $timeInSeconds): string
    {
        $timeInMs = $timeInSeconds * 1000;

        if ($timeInMs < 1) {
            return round($timeInMs * 1000, 2).'μs';
        }

        if ($timeInMs < 1000) {
            return round($timeInMs, 4).'ms';
        }

        return round($timeInSeconds, 2).'s';
    }

    private function formatMemory(float $bytes): string
    {
        if ($bytes === 0.0) {
            return '0B';
        }

        if (abs($bytes) < 1024) {
            return round($bytes, 2).'B';
        }

        if (abs($bytes) < 1048576) {
            return round($bytes / 1024, 2).'KB';
        }

        return round($bytes / 1048576, 2).'MB';
    }

    /**
     * @return array<string, mixed>
     */
    private function getTestCases(): array
    {
        return [
            'null value' => null,
            'empty string' => '',
            'whitespace string' => '   ',
            'zero string' => '0',
            'zero integer' => 0,
            'false boolean' => false,
            'empty array' => [],
            'non-empty string' => 'hello world',
            'non-empty array' => [1, 2, 3, 4, 5],
            'true boolean' => true,
        ];
    }
}
