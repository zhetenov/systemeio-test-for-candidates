<?php

declare(strict_types=1);

namespace App\Exception;

use Exception;

/**
 * Class PaymentException.
 */
final class PaymentException extends Exception
{
    /**
     * @param string $message
     * @return static
     * @throws PaymentException
     */
    public static function stripePaymentException(string $message): self
    {
        throw new self(sprintf('Stripe Payment Error message: %s', $message));
    }

    /**
     * @param string $type
     * @return static
     * @throws PaymentException
     */
    public static function unsupportedPaymentType(string $type): self
    {
        throw new self(sprintf('Unsupported payment processor type: %s', $type));
    }
}