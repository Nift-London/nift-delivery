<?php

declare(strict_types=1);

namespace App\Quote\Infrastructure\Evermile\Builder;

use App\Quote\Application\DTO\AddressDTO;
use App\Quote\Application\DTO\ItemDTO;
use App\Quote\Application\DTO\StoreDTO;

final class EvermileQuoteRequestBuilder
{
    /** @param ItemDTO[] $items */
    public function build(AddressDTO $address, StoreDTO $store, array $items): array
    {
        $itemList = [];
        $itemsWeightKg = 0;

        foreach ($items as $item) {
            $weightKg = $item->getWeightInGrams() === 0 ? 1 : $item->getWeightInGrams() / 1000;

            $itemList[] = [
                'description' => $item->getName(),
                'quantity' => $item->getQuantity(),
                'value' => [
                    'value' => $item->getPrice(),
                    'currency' => 'GBP',
                ],
                'weightKg' => $weightKg,
            ];

            $itemsWeightKg += $weightKg;
        }

        return [
            'pickup_info' => [
                'pickupLocations' => [
                    [
                        'locationId' => $store->getEvermileLocationId(),
                    ]
                ]
            ],
            'destination_locations' => [
                [
                    'address' => [
                        'addressLine1' => $address->getStreet(),
                        'city' => $address->getCity(),
                        'postalCode' => $address->getPostalCode(),
                    ]
                ]
            ],
            'parcels' => [
                [
                    'parcelType' => 'parcel',
                    'itemsList' => $itemList,
                    'weightKg' => $itemsWeightKg === 0 ? 1 : $itemsWeightKg,
                    'dimensions' => [
                        'lengthCm' => 10,
                        'widthCm' => 10,
                        'heightCm' => 10
                    ]
                ]
            ],
        ];
    }
}
