<?php

declare(strict_types=1);

namespace App\Quote\Application\DTO;

use Symfony\Component\Uid\Uuid;

final class LocationDTO
{
    private string $evermileLocationId;
    private Uuid $id;

    public function __construct(Uuid $id, string $evermileLocationId)
    {
        $this->evermileLocationId = $evermileLocationId;
        $this->id = $id;
    }

    public function getEvermileLocationId(): string
    {
        return $this->evermileLocationId;
    }

    public function getId(): Uuid
    {
        return $this->id;
    }
}
