<?php

declare(strict_types=1);

use Laravelcm\Gamify\PointType;

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
