<?php

declare(strict_types=1);

namespace App\Order\Domain\Entity;

use App\Quote\Domain\Entity\Quote;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity]
class DeliveryOrder
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private Uuid $id;

    #[ORM\Column(type: 'text')]
    private string $externalId;

    #[ORM\Column(type: 'datetimetz_immutable')]
    private \DateTimeImmutable $createdAt;

    #[ORM\OneToOne(targetEntity: Quote::class, mappedBy: 'deliveryOrder')]
    private Quote $quote;

    public function __construct(Quote $quote, string $externalId)
    {
        $this->createdAt = new \DateTimeImmutable();
        $quote->setDeliveryOrder($this);
        $this->quote = $quote;
        $this->externalId = $externalId;
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getExternalId(): string
    {
        return $this->externalId;
    }

    public function getQuote(): Quote
    {
        return $this->quote;
    }
}
