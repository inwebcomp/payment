<?php

namespace InWeb\Payment\Enums;

enum TransactionState: string
{
    case ACTIVE = 'active';
    case FINISHED = 'finished';
    case CANCELED = 'canceled';
    case RETURNED = 'returned';
}
