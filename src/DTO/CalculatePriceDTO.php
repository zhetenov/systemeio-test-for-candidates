<?php

declare(strict_types=1);

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;
use App\Validator\Constraints\TaxNumber;

/**
 * Class CalculatePriceDTO.
 */
final class CalculatePriceDTO
{
    public function __construct(
        #[Assert\Type('integer'), Assert\NotNull]
        public readonly int $product,

        #[Assert\Type('string'), Assert\NotNull, TaxNumber]
        public readonly string $taxNumber,

        #[Assert\Type('string'), Assert\NotBlank]
        public readonly string $couponCode,
    ) {
    }

    /**
     * @return int
     */
    public function getProduct(): int
    {
        return $this->product;
    }

    /**
     * @return string
     */
    public function getTaxNumber(): string
    {
        return $this->taxNumber;
    }

    /**
     * @return string
     */
    public function getCouponCode(): string
    {
        return $this->couponCode;
    }
}
