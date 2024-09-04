<?php

declare(strict_types=1);

namespace App\Quote\Infrastructure\Evermile\Builder;

use App\Quote\Application\DTO\AddressDTO;
use App\Quote\Application\DTO\StoreDTO;

final class EvermileQuoteRequestBuilder
{
    public function build(AddressDTO $address, StoreDTO $store): array
    {
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
                    'itemsList' => [[
                        'description' => 'Pair of Jeans',
                        'quantity' => 1,
                        'value' => [
                            'value' => 5000,
                            'currency' => 'GBP'
                        ],
                        'weightKg' => 1
                    ]],
                    'weightKg' => 1,
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
