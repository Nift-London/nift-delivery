<?php

declare(strict_types=1);

namespace App\Quote\Application\DTO;

use App\Quote\Domain\Enum\QuoteTypeEnum;
use Symfony\Component\Uid\Uuid;

final class LocationDTO
{
    private string $evermileLocationId;
    private Uuid $id;
    private array $enabledTypesWithPrices;

    public function __construct(Uuid $id, string $evermileLocationId, array $enabledTypesWithPrices)
    {
        $this->evermileLocationId = $evermileLocationId;
        $this->id = $id;
        $this->enabledTypesWithPrices = $enabledTypesWithPrices;
    }

    public function getEvermileLocationId(): string
    {
        return $this->evermileLocationId;
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    /** @return QuoteTypeEnum[] */
    public function getEnabledTypesWithPrices(): array
    {
        return $this->enabledTypesWithPrices;
    }
}
