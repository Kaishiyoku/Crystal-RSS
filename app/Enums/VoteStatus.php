<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class VoteStatus extends Enum
{
    const None = 'NONE';
    const Up = 'UP';
    const Down = 'DOWN';
}
