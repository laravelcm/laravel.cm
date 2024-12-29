<?php

declare(strict_types=1);

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

final class Welcome extends Mailable implements ShouldQueue
{
    use Queueable;
    use SerializesModels;

    public function __construct(public readonly User $user) {}

    public function build(): self
    {
        return $this->from('john@laravel.cd', 'Jean Claude Mbiya')
            ->subject(__('Bienvenue sur Laravel DRC ✨'))
            ->markdown('emails.welcome');
    }
}
