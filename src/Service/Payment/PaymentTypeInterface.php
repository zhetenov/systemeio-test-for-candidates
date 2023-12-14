<?php

declare(strict_types=1);

namespace App\Service\Payment;

/**
 * Interface PaymentTypeInterface.
 */
interface PaymentTypeInterface
{
    public const TYPE_PAYPAL = 'paypal';
    public const TYPE_STRIPE = 'stripe';
}
