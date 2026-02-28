<?php

namespace App\Enums;

enum TransactionStatusEnum: int
{
    case PENDING = 1;
    case COMPLETED = 2;
    case FAILED = 3;
}
