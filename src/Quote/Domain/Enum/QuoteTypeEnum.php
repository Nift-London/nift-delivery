<?php

declare(strict_types=1);

namespace App\Quote\Domain\Enum;

enum QuoteTypeEnum: string
{
    case EVERMILE_TONIGHT = 'EVERMILE_TONIGHT';
    case EVERMILE_TODAY = 'EVERMILE_TODAY';
    case EVERMILE_TOMORROW = 'EVERMILE_TOMORROW';
}
