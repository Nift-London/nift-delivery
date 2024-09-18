<?php

declare(strict_types=1);

namespace App\UI\Order;

use App\Order\Infrastructure\Command\DTO\OrderCommandDTO;
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
        $requestArr = json_decode($request->getContent(), true);
        $shippingId = explode('#', $requestArr['shipping_lines'][0]['code'])[1];
        $shippingContactName = $requestArr['shipping_address']['name'];

        $orderCommand = new OrderCommandDTO($shippingId, $shippingContactName);

        try {
            $this->orderCommand->order($orderCommand);
        } catch (QuoteNotFoundException $e) {
            return $this->json(['error' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        }

        return $this->json([]);
    }

    // todo remove
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(Request $request): Response {
        return $this->json([]);
    }
}
