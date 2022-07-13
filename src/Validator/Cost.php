<?php declare(strict_types=1);

namespace App\Validator;

use Attribute;
use Symfony\Component\Validator\Constraint;

/**
 * @author "Emmanuel BALLERY" <emmanuel.ballery@gmail.com>
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class Cost extends Constraint
{
}
