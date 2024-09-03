<?php

declare(strict_types=1);

namespace App\Order\Infrastructure\Command;

use App\Order\Application\Orderer\DeliveryOrderer;

final class OrderCommand
{
    private DeliveryOrderer $deliveryOrderer;

    public function __construct(DeliveryOrderer $deliveryOrderer)
    {
        $this->deliveryOrderer = $deliveryOrderer;
    }

    // todo pass DTO with ID and Type
    public function order(string $id): void
    {
        $this->deliveryOrderer->order($id);
    }
}
