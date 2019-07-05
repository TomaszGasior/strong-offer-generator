<?php

namespace App\Util;

use App\Entity\Discount;

class Formatter
{
    public static function formatPrice($value): string
    {
        return number_format($value, 2, ',', ' ') . ' zł';
    }

    public static function formatDiscountValue(Discount $discount): string
    {
        if (Discount::TYPE_PERCENT === $discount->getType()) {
            return '-' . $discount->getValue() . '%';
        }
        else {
            return '-' . self::formatPrice($discount->getValue());
        }
    }
}
