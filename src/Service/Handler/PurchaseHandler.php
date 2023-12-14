<?php

declare(strict_types=1);

namespace App\Service\Handler;

use App\Service\Payment\PaymentFactory;
use Throwable;

/**
 * Class PurchaseHandler.
 */
final class PurchaseHandler
{
    /**
     * @param string $paymentType
     * @param float $totalPrice
     * @return bool
     */
    public function handle(string $paymentType, float $totalPrice): bool
    {
        try {
            return PaymentFactory::createPaymentInstance($paymentType)->pay((int) $totalPrice);
        } catch (Throwable $exception) {
            //Todo: Log here
        }
        return false;
    }
}
