<?php

namespace InWeb\Payment\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use InWeb\Base\Entity;

/**
 * Class Payment
 * @package InWeb\Payment\Models
 * @property Model  payer
 * @property Model  payable
 * @property int    status
 * @property float  amount
 * @property array  detail
 * @property Carbon created_at
 * @property Carbon updated_at
 * @property Carbon canceled_at
 * @property string link
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
        ];
    }

    public function statusInfo()
    {
        foreach (self::statuses() as $status) {
            if ($status['value'] == $this->status)
                return $status;
        }
    }

    public function getLinkAttribute()
    {
        return '//some-link';
    }

    /**
     * @return bool
     */
    public function success()
    {
        $this->status = self::STATUS_COMPLETE;

        $payableClass = get_class($this->payable);

        if ($this->payable->status == $payableClass::STATUS_PAYMENT) {
            $this->payable->setStatus($payableClass::STATUS_WORKING);
        }

        return $this->save();
    }

    /**
     * @return bool
     */
    public function cancel()
    {
        $this->status = self::STATUS_CANCELED;
        $this->canceled_at = now();

        return $this->save();
    }
}