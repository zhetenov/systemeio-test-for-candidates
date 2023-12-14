<?php

declare(strict_types=1);

namespace App\Service\Coupon;

use App\Entity\Coupon;

/**
 * Interface CouponStrategyInterface.
 */
interface CouponStrategyInterface
{
    /**
     * @param float $price
     * @param Coupon $coupon
     * @return float
     */
    public function apply(float $price, Coupon $coupon): float;
}
