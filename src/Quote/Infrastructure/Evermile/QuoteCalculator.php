<?php

declare(strict_types=1);

namespace App\Quote\Infrastructure\Evermile;

use App\Common\Evermile\EvermileClient;

final class QuoteCalculator
{
    private EvermileClient $evermileClient;

    public function __construct(EvermileClient $evermileClient)
    {
        $this->evermileClient = $evermileClient;
    }

    public function calculate()
    {
        $this->evermileClient->getPickupLocationsClient();
    }
}
