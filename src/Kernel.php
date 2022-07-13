<?php declare(strict_types=1);

namespace App;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

/**
 * @author "Emmanuel BALLERY" <emmanuel.ballery@gmail.com>
 */
class Kernel extends BaseKernel
{
    use MicroKernelTrait;
}
