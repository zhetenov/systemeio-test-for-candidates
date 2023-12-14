<?php

declare(strict_types=1);

namespace App\Service\Handler;

use App\DTO\PurchaseDTO;
use App\Entity\Order;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Throwable;

/**
 * Class CreateOrderHandler.
 */
final class CreateOrderHandler
{
    private EntityManagerInterface $entityManager;
    private ProductRepository $productRepository;

    public function __construct(EntityManagerInterface $entityManager, ProductRepository $productRepository) {
        $this->entityManager = $entityManager;
        $this->productRepository = $productRepository;
    }

    /**
     * @param PurchaseDTO $dto
     * @param float $totalPrice
     * @return bool
     */
    public function handle(PurchaseDTO $dto, float $totalPrice): bool
    {
        try {
            $product = $this->productRepository->find($dto->getProduct());
            if (!$product) {
                throw new Exception("Product not found");
            }
            $order = new Order();
            $order->setProduct($product);
            $order->setTaxNumber($dto->getTaxNumber());
            $order->setCouponCode($dto->getCouponCode());
            $order->setPaymentProcessor($dto->getPaymentProcessor());
            $order->setTotalPrice((string)$totalPrice);
            $this->entityManager->persist($order);
            $this->entityManager->flush();
            return true;
        } catch (Throwable $exception) {
            //Todo: log here
            return false;
        }
    }
}
