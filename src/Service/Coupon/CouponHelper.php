<?php

declare(strict_types=1);

namespace App\Service\Coupon;

use App\Entity\Coupon;
use JetBrains\PhpStorm\Pure;

/**
 * Class CouponHelper.
 */
final class CouponHelper
{
    public const FIXED = 'fixed';
    public const PERCENT = 'percent';

    /**
     * @param string $type
     * @return CouponStrategyInterface|null
     */
    #[Pure] public static function getCouponStrategy(string $type): ?CouponStrategyInterface
    {
        return match ($type) {
            self::FIXED => new FixedDiscountStrategy(),
            self::PERCENT => new PercentDiscountStrategy(),
            default => null,
        };
    }
}
