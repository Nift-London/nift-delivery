<?php

declare(strict_types=1);

namespace App\UI\Order\Builder\Command;

use App\Order\Infrastructure\Command\DTO\OrderCommandDTO;

final class OrderCommandBuilder
{
    public function build(array $requestArray): OrderCommandDTO
    {
        $shippingId = explode('#', $requestArray['shipping_lines'][0]['code'])[1];
        $shippingName = $requestArray['shipping_address']['name'];
        $shippingPhone = $requestArray['shipping_address']['phone'] ? (string) $requestArray['shipping_address']['phone'] : null;
        $shippingCustomerEmail = $requestArray['customer']['email'] ?? null;

        return new OrderCommandDTO($shippingId, $shippingName, $shippingPhone, $shippingCustomerEmail);
    }
}
