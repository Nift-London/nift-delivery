<?php

declare(strict_types=1);

namespace App\UI\Order;

use App\Order\Infrastructure\Command\OrderCommand;
use App\Quote\Application\Exception\QuoteNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
final class OrderController extends AbstractController
{
    private OrderCommand $orderCommand;

    public function __construct(OrderCommand $orderCommand)
    {
        $this->orderCommand = $orderCommand;
    }

    #[Route('/api/v1/order/shopify', name: 'order', methods: ['POST'])]
    public function orderForShopify(Request $request): Response {
        $shippingCode = json_decode($request->getContent(), true)['shipping_lines'][0]['code'];
        $shippingId = explode('#', $shippingCode)[1];

        try {
            $this->orderCommand->order($shippingId);
        } catch (QuoteNotFoundException $e) {
            return $this->json(['error' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        }

        return $this->json([]);
    }
}
