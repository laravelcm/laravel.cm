<?php

declare(strict_types=1);

namespace App\Events;

use App\Models\Transaction;
use Illuminate\Queue\SerializesModels;

final class SponsoringPaymentInitialize
{
    use SerializesModels;

    public function __construct(public Transaction $transaction)
    {
    }
}
