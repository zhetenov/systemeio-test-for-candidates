<?php

declare(strict_types=1);

namespace App\Service\Coupon;

use App\Entity\Coupon;
use JetBrains\PhpStorm\Pure;

/**
 * Class PercentDiscountStrategy.
 */
final class PercentDiscountStrategy implements CouponStrategyInterface
{
    /**
     * @param float $price
     * @param Coupon $coupon
     * @return float
     */
    #[Pure] public function apply(float $price, Coupon $coupon): float
    {
        return $price * (1 - $coupon->getDiscountValue() / 100);
    }
}
