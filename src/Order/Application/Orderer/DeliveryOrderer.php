<?php

declare(strict_types=1);

namespace App\Order\Application\Orderer;

// in future switch with types
use App\Common\Evermile\Client\EvermileClient;

final class DeliveryOrderer
{
    private EvermileClient $evermileClient;

    public function __construct(EvermileClient $evermileClient)
    {
        $this->evermileClient = $evermileClient;
    }

    public function order(string $id): string
    {
        return $this->evermileClient->order($id)->getId();
    }
}
