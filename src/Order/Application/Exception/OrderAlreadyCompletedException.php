<?php

declare(strict_types=1);

namespace App\Order\Application\Exception;

final class OrderAlreadyCompletedException extends \Exception
{
    public static function orderAlreadyCompleted(string $externalPurchaseId): self
    {
        return new self(sprintf('Order already completed, external purchase id: %s', $externalPurchaseId));
    }
}
