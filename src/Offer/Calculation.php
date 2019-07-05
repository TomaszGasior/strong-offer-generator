<?php

namespace App\Offer;

use App\Entity\Discount;

class Calculation
{
    private $offer;

    public function __construct(Offer $offer)
    {
        $this->offer = $offer;
    }

    public function getOffer(): Offer
    {
        return $this->offer;
    }

    public function getSum(): float
    {
        $values = [];

        foreach ($this->offer->getItems() as $item) {
            $values[] = $item->getPrice();
        }

        return (float) array_sum($values);
    }

    public function getDiscountSum(): float
    {
        $staticDiscounts = [];
        $percentDiscounts = [];

        foreach ($this->offer->getDiscounts() as $discount) {
            if (Discount::TYPE_PERCENT === $discount->getType()) {
                $percentDiscounts[] = $discount->getValue();
            }
            else {
                $staticDiscounts[] = $discount->getValue();
            }
        }

        $staticDiscountsSum = array_sum($staticDiscounts);

        $sum = $this->getSum() - $staticDiscountsSum;
        $percentDiscountsSum = 0.0;

        foreach ($percentDiscounts as $value) {
            $percent = $value * 0.01;
            $thisDiscount = $sum * $percent;
            $percentDiscountsSum += $thisDiscount;
            $sum = $sum - $thisDiscount;
        }

        return (float) ($staticDiscountsSum + $percentDiscountsSum);
    }

    public function getSumAfterDiscounts(): float
    {
        return $this->getSum() - $this->getDiscountSum();
    }
}
