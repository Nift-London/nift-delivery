<?php

declare(strict_types=1);

namespace App\Order\Domain\Repository;

use App\Order\Domain\Entity\DeliveryOrder;

interface DeliveryOrderRepository
{
    public function save(DeliveryOrder $order): void;
}
