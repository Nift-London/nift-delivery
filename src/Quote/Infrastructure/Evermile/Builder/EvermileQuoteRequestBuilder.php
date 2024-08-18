<?php

declare(strict_types=1);

namespace App\Quote\Infrastructure\Evermile\Builder;

use App\Quote\Domain\DTO\AddressDTO;
use App\Quote\Domain\DTO\StoreDTO;

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
