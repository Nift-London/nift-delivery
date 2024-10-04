<?php

declare(strict_types=1);

namespace App\UI\Quote\Builder\Request;

use App\UI\Quote\DTO\Request\Partial\QuoteForShopifyAddress;
use App\UI\Quote\DTO\Request\Partial\QuoteForShopifyItem;
use App\UI\Quote\DTO\Request\QuoteForShopifyRequest;
use Symfony\Component\HttpFoundation\Request;

final class QuoteForShopifyRequestBuilder
{
    public function build(Request $request): QuoteForShopifyRequest
    {
        $parameters = json_decode($request->getContent(), true);

        $origin = (new QuoteForShopifyAddress())
            ->setCountry($parameters['rate']['origin']['country'])
            ->setPostalCode($parameters['rate']['origin']['postal_code'])
            ->setProvince($parameters['rate']['origin']['province'])
            ->setCity($parameters['rate']['origin']['city'])
            ->setName($parameters['rate']['origin']['name'])
            ->setAddress1($parameters['rate']['origin']['address1'])
            ->setAddress2($parameters['rate']['origin']['address2'])
            ->setAddress3($parameters['rate']['origin']['address3'])
            ->setCompanyName($parameters['rate']['origin']['company_name']);

        $destination = (new QuoteForShopifyAddress())
            ->setCountry($parameters['rate']['destination']['country'])
            ->setPostalCode($parameters['rate']['destination']['postal_code'])
            ->setProvince($parameters['rate']['destination']['province'])
            ->setCity($parameters['rate']['destination']['city'])
            ->setName($parameters['rate']['destination']['name'])
            ->setAddress1($parameters['rate']['destination']['address1'])
            ->setAddress2($parameters['rate']['destination']['address2'])
            ->setAddress3($parameters['rate']['destination']['address3'])
            ->setCompanyName($parameters['rate']['destination']['company_name']);

        $items = [];

        foreach ($parameters['rate']['items'] as $item) {
            $items[] = (new QuoteForShopifyItem())
                ->setName($item['name'])
                ->setSku($item['sku'])
                ->setQuantity($item['quantity'])
                ->setGrams($item['grams'])
                ->setPrice($item['price'])
                ->setVendor($item['vendor'])
                ->setRequiresShipping($item['requires_shipping'])
                ->setTaxable($item['taxable'])
                ->setFulfillmentService($item['fulfillment_service'])
                ->setProperties($item['properties'])
                ->setProductId($item['product_id'])
                ->setVariantId($item['variant_id']);
        }

        return (new QuoteForShopifyRequest())
            ->setShopifyDomain($request->headers->get('X-Shopify-Shop-Domain'))
            ->setOrigin($origin)
            ->setDestination($destination)
            ->setItems($items);
    }
}
