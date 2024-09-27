<?php

declare(strict_types=1);

namespace App\UI\Order\Builder\Command;

use App\Order\Infrastructure\Command\DTO\OrderCommandDTO;
use App\Quote\Domain\Enum\QuoteTypeEnum;

final class OrderCommandBuilder
{
    public function build(array $requestArray): OrderCommandDTO
    {
        $shippingName = $requestArray['shipping_address']['name'];
        $shippingStreet = trim($requestArray['shipping_address']['address1'] . ' ' . $requestArray['shipping_address']['address2']);
        $shippingCity = $requestArray['shipping_address']['city'];
        $shippingPostalCode = $requestArray['shipping_address']['zip'];
        $shippingPhone = $requestArray['shipping_address']['phone'] ? (string) $requestArray['shipping_address']['phone'] : null;
        $shippingCustomerEmail = $requestArray['customer']['email'] ?? null;
        $shippingCode = QuoteTypeEnum::from($requestArray['shipping_lines'][0]['code']);
        $externalPurchaseId = (string) $requestArray['id'];

        return new OrderCommandDTO(
            $shippingName,
            $shippingStreet,
            $shippingPostalCode,
            $shippingCity,
            $shippingPhone,
            $shippingCustomerEmail,
            $shippingCode,
            $externalPurchaseId
        );
    }
}
