<?php

declare(strict_types=1);

namespace App\Service\Payment;

/**
 * Interface PaymentInterface.
 */
interface PaymentInterface
{
    /**
     * @param int $amount
     * @return bool
     */
    public function pay(int $amount): bool;
}
