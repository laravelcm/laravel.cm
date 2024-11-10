<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\User;
use App\Mail\UserBannedEMail;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

final class SendBanEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public User $user){}

    public function handle(): void
    {
        Mail::to($this->user->email)->send(new UserBannedEMail($this->user));
    }
}