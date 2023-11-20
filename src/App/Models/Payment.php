<?php

namespace InWeb\Payment\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use InWeb\Base\Entity;
use InWeb\Payment\Contracts\Payable;
use InWeb\Payment\Contracts\Payer;

/**
 * Class Payment
 * @package InWeb\Payment\Models
 * @property Payer       payer
 * @property Payable     payable
 * @property int         status
 * @property float       amount
 * @property array       detail
 * @property Carbon      created_at
 * @property Carbon      updated_at
 * @property Carbon      canceled_at
 * @property string      link
 * @property string|null gatewayUrl
 * @property string|null transactionId
 */
class Payment extends Entity
{
    const STATUS_PENDING = 0;
    const STATUS_COMPLETE = 1;
    const STATUS_FAILED = 2;
    const STATUS_CANCELED = 3;
    const STATUS_INPROGRESS = 4;

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

    public static function statuses()
    {
        return [
            [
                'title' => __('Ожидает оплаты'),
                'value' => self::STATUS_PENDING,
                'color' => 'blue'
            ],
            [
                'title' => __('Завершён'),
                'value' => self::STATUS_COMPLETE,
                'color' => 'green'
            ],
            [
                'title' => __('Произошла ошибка'),
                'value' => self::STATUS_FAILED,
                'color' => 'red'
            ],
            [
                'title' => __('Отменён'),
                'value' => self::STATUS_CANCELED,
                'color' => 'grey'
            ],
            [
                'title' => __('В процессе'),
                'value' => self::STATUS_INPROGRESS,
                'color' => 'yellow'
            ]
        ];
    }

    public function statusInfo()
    {
        foreach (self::statuses() as $status) {
            if ($status['value'] == $this->status) {
                return $status;
            }
        }
    }

    public function getLinkAttribute()
    {
        return '//some-link';
    }

    public function success(): bool
    {
        $this->status = self::STATUS_COMPLETE;

        $payableClass = get_class($this->payable);

        // @todo Wtf is this?
        if ($this->payable->status == $payableClass::STATUS_PAYMENT) {
            $this->payable->setStatus($payableClass::STATUS_WORKING);
        }

        return $this->save();
    }

    public function beginProcess() {
        $this->status = self::STATUS_INPROGRESS;

        return $this->save();
    }

    public function cancel(): bool
    {
        $this->status = self::STATUS_CANCELED;
        $this->canceled_at = now();

        return $this->save();
    }

    public function fail(): bool
    {
        $this->status = self::STATUS_FAILED;

        return $this->save();
    }

    public function setDetail($data, $append = false)
    {
        if ($append === false) {
            $detail = [];
        } else {
            $detail = $this->detail ?? [];
        }

        $detail = array_merge($detail, $data);

        $this->detail = $detail;
    }

    public function getGatewayUrlAttribute(): string | null
    {
        return optional($this->detail)['gateway_url'];
    }

    public function getTransactionIdAttribute(): string | null
    {
        return optional($this->detail)['transaction_id'];
    }
}
