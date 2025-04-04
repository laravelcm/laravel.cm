<?php

declare(strict_types=1);

namespace QCod\Gamify;

use Illuminate\Database\Eloquent\Model;

final class Reputation extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * Payee user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function payee()
    {
        return $this->belongsTo(config('gamify.payee_model'), 'payee_id');
    }

    /**
     * Get the owning subject model
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function subject()
    {
        return $this->morphTo();
    }

    /**
     * Undo last point
     *
     * @throws \Exception
     */
    public function undo(): void
    {
        if ($this->exists) {
            $this->payee->reducePoint($this->point);
            $this->delete();
        }
    }
}
