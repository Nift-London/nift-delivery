<?php

declare(strict_types=1);

namespace App\UI\Quote\Builder\Request;

use App\UI\Quote\DTO\Request\Partial\QuoteAddress;
use App\UI\Quote\DTO\Request\Partial\QuoteItem;
use App\UI\Quote\DTO\Request\QuoteRequest;
use Symfony\Component\HttpFoundation\Request;

final class QuoteRequestBuilder
{
    public function build(Request $request): QuoteRequest
    {
        $parameters = json_decode($request->getContent(), true);

        $origin = (new QuoteAddress())
            ->setCountry($parameters['origin']['country'])
            ->setPostalCode($parameters['origin']['postal_code'])
            ->setProvince($parameters['origin']['province'])
            ->setCity($parameters['origin']['city'])
            ->setName($parameters['origin']['name'])
            ->setAddress($parameters['origin']['address']);

        $destination = (new QuoteAddress())
            ->setCountry($parameters['destination']['country'])
            ->setPostalCode($parameters['destination']['postal_code'])
            ->setProvince($parameters['destination']['province'])
            ->setCity($parameters['destination']['city'])
            ->setName($parameters['destination']['name'])
            ->setAddress($parameters['destination']['address']);

        $items = [];

        foreach ($parameters['items'] as $item) {
            $items[] = (new QuoteItem())
                ->setName($item['name'])
                ->setQuantity($item['quantity'])
                ->setGrams($item['grams'])
                ->setPrice($item['price']);
        }

        return (new QuoteRequest())
            ->setOrigin($origin)
            ->setDestination($destination)
            ->setItems($items);
    }
}
