<?php

declare(strict_types=1);

namespace App\Service\Payment;

use App\Exception\PaymentException;
use JetBrains\PhpStorm\Pure;
use Systemeio\TestForCandidates\PaymentProcessor\PaypalPaymentProcessor;
use Throwable;

/**
 * Class PaypalPaymentAdapter.
 */
final class PaypalPaymentAdapter implements PaymentInterface
{
    /** @var PaypalPaymentProcessor */
    private PaypalPaymentProcessor $paymentProcessor;

    #[Pure] public function __construct()
    {
        $this->paymentProcessor = new PaypalPaymentProcessor();
    }

    /**
     * @param int $amount
     * @return bool
     * @throws PaymentException
     */
    public function pay(int $amount): bool
    {
        try {
            $this->paymentProcessor->pay($amount);
        } catch (Throwable $exception) {
            throw PaymentException::stripePaymentException($exception->getMessage());
        }

        return true;
    }
}
