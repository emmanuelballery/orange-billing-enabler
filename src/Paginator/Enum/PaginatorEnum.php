<?php declare(strict_types=1);

namespace App\Paginator\Enum;

/**
 * @author "Emmanuel BALLERY" <emmanuel.ballery@gmail.com>
 */
abstract class PaginatorEnum
{
    public const DEFAULT_LIMIT = 10;
    public const MAX_LIMIT = 100;
    public const PAGE_PARAMETER = 'page';
    public const LIMIT_PARAMETER = 'limit';
    public const OFFSET_PARAMETER = 'offset';
    public const ORDER_PARAMETER = 'order';
    public const DIRECTION_PARAMETER = 'direction';
}
