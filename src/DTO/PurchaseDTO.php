<?php

declare(strict_types=1);

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;
use App\Validator\Constraints\TaxNumber;

/**
 * Class PurchaseDTO.
 */
final class PurchaseDTO
{
    public function __construct(
        #[Assert\Type('integer'), Assert\NotNull]
        private readonly int $product,

        #[Assert\Type('string'), Assert\NotNull, TaxNumber]
        private readonly string $taxNumber,

        #[Assert\Type('string'), Assert\NotBlank]
        private readonly string $couponCode,

        #[Assert\Type('string'), Assert\NotBlank]
        private readonly string $paymentProcessor
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

    /**
     * @return string
     */
    public function getPaymentProcessor(): string
    {
        return $this->paymentProcessor;
    }
}
