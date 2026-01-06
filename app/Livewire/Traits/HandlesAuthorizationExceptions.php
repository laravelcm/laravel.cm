<?php

declare(strict_types=1);

namespace App\Livewire\Traits;

use Exception;
use Flux\Flux;
use Illuminate\Auth\Access\AuthorizationException;

trait HandlesAuthorizationExceptions
{
    public function exception(Exception $e, callable $stopPropagation): void
    {
        if ($e instanceof AuthorizationException) {
            Flux::toast(
                text: $e->getMessage() ?: __('notifications.database.unauthorized_action'),
                heading: __('Authorization'),
                variant: 'danger',
            );

            $stopPropagation();
        }
    }
}
