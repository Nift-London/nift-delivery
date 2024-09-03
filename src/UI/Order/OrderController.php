<?php

declare(strict_types=1);

namespace App\UI\Order;

use App\Order\Infrastructure\Command\OrderCommand;
use App\Quote\Application\Exception\QuoteNotFoundException;
use App\Quote\Infrastructure\Query\QuoteQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Uid\Uuid;

#[AsController]
final class OrderController extends AbstractController
{
    private QuoteQuery $quoteQuery;
    private OrderCommand $orderCommand;

    public function __construct(QuoteQuery $quoteQuery, OrderCommand $orderCommand)
    {
        $this->quoteQuery = $quoteQuery;
        $this->orderCommand = $orderCommand;
    }

    #[Route('/api/v1/order/shopify', name: 'order', methods: ['POST'])]
    public function orderForShopify(Request $request): Response {
        $shippingCode = json_decode($request->getContent(), true)['shipping_lines'][0]['code'];
        $shippingId = explode('#', $shippingCode)[1];

        try {
            $quote = $this->quoteQuery->query(Uuid::fromString($shippingId));
            $this->orderCommand->order($quote->getExternalId());
        } catch (QuoteNotFoundException $e) {
            return $this->json(['error' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        }

        return $this->json([]);
    }
}
