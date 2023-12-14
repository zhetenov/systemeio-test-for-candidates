<?php

declare(strict_types=1);

namespace App\Service\Payment;

use App\Exception\PaymentException;
use JetBrains\PhpStorm\Pure;
use Systemeio\TestForCandidates\PaymentProcessor\StripePaymentProcessor;
use Throwable;

/**
 * Class StripePaymentAdapter.
 */
final class StripePaymentAdapter implements PaymentInterface
{
    /** @var StripePaymentProcessor */
    private StripePaymentProcessor $paymentProcessor;

    #[Pure] public function __construct()
    {
        $this->paymentProcessor = new StripePaymentProcessor();
    }

    /**
     * @param int $amount
     * @return bool
     * @throws PaymentException
     */
    public function pay(int $amount): bool
    {
        try {
            return $this->paymentProcessor->processPayment($amount);
        } catch (Throwable $exception) {
            throw PaymentException::stripePaymentException($exception->getMessage());
        }
    }
}
