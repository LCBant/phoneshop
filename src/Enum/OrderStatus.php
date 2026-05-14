<?php

namespace App\Enum;

enum OrderStatus: string {
    case Pending = 'product';
    case Processing = 'processing';
    case Shipped = 'shipped';
    case Delivered = 'delivered';
    case Cancelled = 'cancelled';
}