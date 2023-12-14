<?php

declare(strict_types=1);

namespace App\Service\Coupon;

use App\Entity\Coupon;
use JetBrains\PhpStorm\Pure;

/**
 * Class FixedDiscountStrategy.
 */
final class FixedDiscountStrategy implements CouponStrategyInterface
{
    /**
     * @param float $price
     * @param Coupon $coupon
     * @return float
     */
    #[Pure] public function apply(float $price, Coupon $coupon): float
    {
        return max($price - $coupon->getDiscountValue(), 0);
    }
}
