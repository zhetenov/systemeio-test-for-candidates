<?php

declare(strict_types=1);

namespace App\Controller;

use App\DTO\CalculatePriceDTO;
use App\DTO\PurchaseDTO;
use App\Service\Handler\CalculatePriceHandler;
use App\Service\Handler\CreateOrderHandler;
use App\Service\Handler\PurchaseHandler;
use JetBrains\PhpStorm\Pure;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CheckoutController.
 */
final class CheckoutController extends AbstractController
{
    #[Pure] public function __construct(
        protected CalculatePriceHandler $calculatePriceHandler,
        protected PurchaseHandler $purchaseHandler,
        protected CreateOrderHandler $createOrderHandler,
    ) {
    }

    #[Route('/calculate-price', methods: ['Post'])]
    public function index(#[MapRequestPayload] CalculatePriceDTO $dto): JsonResponse
    {
        return $this->json($this->calculatePriceHandler->handle($dto));
    }

    #[Route('/purchase', methods: ['Post'])]
    public function purchase(#[MapRequestPayload] PurchaseDTO $dto): JsonResponse
    {
        $calculatePriceDto = new CalculatePriceDTO(
            $dto->getProduct(),
            $dto->getTaxNumber(),
            $dto->getCouponCode()
        );
        $calculatePrice = $this->calculatePriceHandler->handle($calculatePriceDto);
        if (!($calculatePrice['success'] ?? false)) {
            return $this->json([
                'success' => false,
                'message' => 'can not get price',
            ]);
        }
        $purchase = $this->purchaseHandler->handle($dto->getPaymentProcessor(), $calculatePrice['totalPrice']);
        if (!$purchase) {
            return $this->json([
                'success' => false,
                'message' => 'Payment Error',
            ]);
        }
        $result = $this->createOrderHandler->handle($dto, $calculatePrice['totalPrice']);

        return $this->json(['success' => $result]);
    }
}
