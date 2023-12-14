<?php

declare(strict_types=1);

namespace App\Service\Payment;

use App\Exception\PaymentException;

/**
 * Class PaymentFactory.
 */
final class PaymentFactory
{
    /**
     * Create a payment instance based on the provided processor type.
     *
     * @param string $processorType
     * @return PaymentInterface
     * @throws PaymentException
     */
    public static function createPaymentInstance(string $processorType): PaymentInterface
    {
        return match ($processorType) {
            PaymentTypeInterface::TYPE_PAYPAL => new PaypalPaymentAdapter(),
            PaymentTypeInterface::TYPE_STRIPE => new StripePaymentAdapter(),
            default => PaymentException::unsupportedPaymentType($processorType),
        };
    }
}
