<?php declare(strict_types=1);

namespace App\Enum;

/**
 * @author "Emmanuel BALLERY" <emmanuel.ballery@gmail.com>
 */
abstract class PeriodicityEnum
{
    public const ALL = [
        self::DAILY,
        self::MONTHY,
        self::WEEKLY,
    ];
    public const DAILY = 'daily';
    public const MONTHY = 'monthly';
    public const WEEKLY = 'weekly';
}
