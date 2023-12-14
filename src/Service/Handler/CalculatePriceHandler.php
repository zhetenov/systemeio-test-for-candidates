<?php

declare(strict_types=1);

namespace App\Service\Handler;

use App\DTO\CalculatePriceDTO;
use App\Entity\Coupon;
use App\Repository\CouponRepository;
use App\Repository\ProductRepository;
use App\Repository\TaxRepository;
use App\Service\Coupon\CouponHelper;
use Exception;
use Throwable;

/**
 * Class CalculatePriceHandler.
 */
final class CalculatePriceHandler
{
    private ProductRepository $productRepository;
    private TaxRepository $taxRepository;
    private CouponRepository $couponRepository;

    public function __construct(
        ProductRepository $productRepository,
        TaxRepository $taxRepository,
        CouponRepository $couponRepository,
    ) {
        $this->productRepository = $productRepository;
        $this->taxRepository = $taxRepository;
        $this->couponRepository = $couponRepository;
    }

    /**
     * @param CalculatePriceDTO $dto
     * @return array
     */
    public function handle(CalculatePriceDTO $dto): array
    {
        try {
            $product = $this->productRepository->find($dto->getProduct());
            if (!$product) {
                throw new Exception("Product not found");
            }

            $taxRate = $this->getTaxRate($dto->getTaxNumber());
            $priceWithTax = $product->getPrice() * (1 + $taxRate / 100);

            if ($dto->getCouponCode()) {
                $coupon = $this->couponRepository->findOneBy(['code' => $dto->getCouponCode()]);
                if ($coupon) {
                    $priceWithTax = $this->applyCoupon($priceWithTax, $coupon);
                }
            }

            return [
                'success' => true,
                'totalPrice' => $priceWithTax
            ];
        } catch (Throwable $e) {
            //Todo: log here
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * @param string $taxNumber
     * @return float
     */
    private function getTaxRate(string $taxNumber): float
    {
        $countryCode = substr($taxNumber, 0, 2);
        $tax = $this->taxRepository->findOneBy(['country' => $countryCode]);
        $taxRate = 0;
        if ($tax) {
            $taxRate = $tax->getRate();
        }
        return (float)$taxRate;
    }

    /**
     * @param float $price
     * @param Coupon $coupon
     * @return float
     */
    private function applyCoupon(float $price, Coupon $coupon): float
    {
        $couponStrategy = CouponHelper::getCouponStrategy($coupon->getDiscountType());
        if (is_null($couponStrategy)) {
            return $price;
        }
        return $couponStrategy->apply($price, $coupon);
    }
}
