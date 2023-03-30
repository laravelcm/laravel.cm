<?php

declare(strict_types=1);

namespace App\Mail;

use App\Models\Reply;
use App\Models\Subscribe;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;

class NewReplyEmail extends Mailable implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(
        public readonly Reply $reply,
        public readonly Subscribe $subscription
    ) {
    }

    public function build(): self
    {
        return $this->subject("Re: {$this->reply->replyAble->subject()}")
            ->markdown('emails.new_reply');
    }
}
