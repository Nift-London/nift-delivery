<?php

declare(strict_types=1);

namespace App\Order\Infrastructure\Command;

use App\Order\Application\Orderer\DeliveryOrderer;
use App\Order\Domain\Entity\DeliveryOrder;
use App\Order\Domain\Repository\DeliveryOrderRepository;
use App\Order\Infrastructure\Command\DTO\OrderCommandDTO;
use App\Quote\Infrastructure\Query\QuoteQuery;
use Symfony\Component\Uid\Uuid;

final class OrderCommand
{
    private DeliveryOrderer $deliveryOrderer;
    private QuoteQuery $quoteQuery;
    private DeliveryOrderRepository $orderRepository;

    public function __construct(
        DeliveryOrderer $deliveryOrderer,
        QuoteQuery $quoteQuery,
        DeliveryOrderRepository $orderRepository
    ) {
        $this->deliveryOrderer = $deliveryOrderer;
        $this->quoteQuery = $quoteQuery;
        $this->orderRepository = $orderRepository;
    }

    public function order(OrderCommandDTO $orderCommandDTO): void
    {
        $quote = $this->quoteQuery->query(Uuid::fromString($orderCommandDTO->getShippingId()));
        $externalOrderId = $this->deliveryOrderer->order($quote->getExternalId(), $orderCommandDTO);
        $order = new DeliveryOrder($quote, $externalOrderId);
        $order->setShipmentRecipientName($orderCommandDTO->getContactName());
        $this->orderRepository->save($order);
    }
}
