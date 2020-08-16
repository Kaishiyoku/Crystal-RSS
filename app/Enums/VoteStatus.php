<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static None()
 * @method static static Up()
 * @method static static Down()
 */
final class VoteStatus extends Enum
{
    const None = 'NONE';
    const Up = 'UP';
    const Down = 'DOWN';
}
