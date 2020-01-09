<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static MONDAY()
 * @method static static TUESDAY()
 * @method static static WEDNESDAY()
 * @method static static THURSDAY()
 * @method static static FRIDAY()
 * @method static static SATURDAY()
 * @method static static SUNDAY()
 */
final class Weekday extends Enum
{
    const MONDAY = 1;
    const TUESDAY = 2;
    const WEDNESDAY = 3;
    const THURSDAY = 4;
    const FRIDAY = 5;
    const SATURDAY = 6;
    const SUNDAY = 7;
}
