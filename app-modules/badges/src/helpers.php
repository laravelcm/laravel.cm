<?php

declare(strict_types=1);

use Laravelcm\Badges\PointType;

if (! function_exists('givePoint')) {

    /**
     * Give point to user
     *
     * @param  null  $payee
     */
    function givePoint(PointType $pointType, $payee = null): void
    {
        $payee = $payee ?? auth()->user();

        if (! $payee) {
            return;
        }

        $payee->givePoint($pointType);
    }
}

if (! function_exists('undoPoint')) {

    /**
     * Undo a given point
     *
     * @param  null  $payee
     */
    function undoPoint(PointType $pointType, $payee = null): void
    {
        $payee = $payee ?? auth()->user();

        if (! $payee) {
            return;
        }

        $payee->undoPoint($pointType);
    }
}

if (! function_exists('short_number')) {

    /**
     * Convert large positive numbers in to short form like 1K+, 100K+, 199K+, 1M+, 10M+, 1B+ etc
     *
     * @param  $n  int
     * @return string
     */
    function short_number($n)
    {
        if ($n >= 0 && $n < 1000) {
            $n_format = floor($n);
            $suffix = '';
        } elseif ($n >= 1000 && $n < 1000000) {
            $n_format = floor($n / 1000);
            $suffix = 'K+';
        } elseif ($n >= 1000000 && $n < 1000000000) {
            $n_format = floor($n / 1000000);
            $suffix = 'M+';
        } else {
            $n_format = floor($n / 1000000000);
            $suffix = 'B+';
        }

        return ! empty($n_format.$suffix) ? $n_format.$suffix : '0';
    }
}
