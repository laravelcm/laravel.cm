<?php

declare(strict_types=1);

use App\Models\User;
use Laravelcm\Gamify\PointType;

if (! function_exists('givePoint')) {

    /**
     * Give point to user
     */
    function givePoint(PointType $pointType, ?User $payee = null): void
    {
        $payee ??= auth()->user();

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
     * @throws Laravelcm\Gamify\Exceptions\InvalidPayeeModelException
     * @throws Laravelcm\Gamify\Exceptions\PointSubjectNotSetException
     */
    function undoPoint(PointType $pointType, ?User $payee = null): void
    {
        $payee ??= auth()->user();

        if (! $payee) {
            return;
        }

        $payee->undoPoint($pointType);
    }
}
