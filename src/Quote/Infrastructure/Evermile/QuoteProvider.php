<?php

declare(strict_types=1);

namespace App\Quote\Infrastructure\Evermile;

use App\Common\Evermile\EvermileClient;
use App\Quote\Application\Calculator\Provider\QuoteProviderInterface;
use App\Quote\Domain\DTO\AddressDTO;
use App\Quote\Domain\DTO\QuoteDTO;

final class QuoteProvider implements QuoteProviderInterface
{
    private EvermileClient $evermileClient;

    public function __construct(EvermileClient $evermileClient)
    {
        $this->evermileClient = $evermileClient;
    }

    /** @return QuoteDTO[] */
    public function provide(AddressDTO $addressDTO): array
    {
        $quotes = [];

        $response = $this->evermileClient->getQuote($this->buildRequest($addressDTO));

        foreach($response->getDateProposals() as $dateProposal) {
            foreach($dateProposal->getProposals() as $proposalOptional) {
                if (is_null($proposalOptional->getProposal())) {
                    continue;
                }

                $proposal = $proposalOptional->getProposal();

                $quotes[] = new QuoteDTO(
                    $proposal->getId(),
                    $proposal->getModelName(),
                    $proposal->getModelName(),
                    $proposal->getModelName(),
                    $proposal->getPriceVat()->getValue(),
                    $proposal->getPriceVat()->getCurrency(),
                    \DateTimeImmutable::createFromMutable($proposal->getEstimatedPickup()->getStart()),
                    \DateTimeImmutable::createFromMutable($proposal->getEstimatedPickup()->getEnd()),
                    \DateTimeImmutable::createFromMutable($proposal->getEstimatedDropoff()->getStart()),
                    \DateTimeImmutable::createFromMutable($proposal->getEstimatedDropoff()->getStart()),
                );
            }

        }
        return $quotes;
    }

    public function buildRequest(AddressDTO $addressDTO): array
    {
        return [
            "pickup_info" => [
                "pickupLocations" => [
                    [
                        "locationId" => "f9e4c4e4-e05e-4020-970c-d71f961fdda0"
                    ]
                ]
            ],
            "destination_locations" => [
                [
                    "address" => [
                        "addressLine1" => $addressDTO->getStreet(),
                        "city" => $addressDTO->getCity(),
                        "postalCode" => $addressDTO->getPostalCode(),
                    ]
                ]
            ],
            "parcels" => [
                [
                    "parcelType" => "parcel",
                    "weightKg" => 1,
                    "dimensions" => [
                        "lengthCm" => 10,
                        "widthCm" => 10,
                        "heightCm" => 10
                    ]
                ]
            ],
        ];
    }
}
