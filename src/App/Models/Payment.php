<?php

namespace InWeb\Payment\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use InWeb\Base\Entity;

/**
 * Class Payment
 * @package InWeb\Payment\Models
 * @property Model payer
 * @property Model payable
 * @property int status
 * @property float amount
 * @property array detail
 * @property Carbon created_at
 * @property Carbon updated_at
 * @property Carbon closed_at
 */
class Payment extends Entity
{
    const STATUS_PENDING = 0;
    const STATUS_COMPLETE = 1;
    const STATUS_FAILED = 2;
    const STATUS_CANCELED = 3;

    protected $fillable = [
        'payer_type',
        'payer_id',
        'payable_type',
        'payable_id',
        'status',
        'amount',
        'detail',
    ];

    protected $casts = [
        'detail' => 'array'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'canceled_at',
    ];

    /**
     * @return MorphTo
     */
    public function payer()
    {
        return $this->morphTo();
    }

    /**
     * @return MorphTo
     */
    public function payable()
    {
        return $this->morphTo();
    }
}