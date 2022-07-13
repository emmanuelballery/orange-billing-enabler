<?php declare(strict_types=1);

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use function is_float;
use function round;

/**
 * @author "Emmanuel BALLERY" <emmanuel.ballery@gmail.com>
 */
class CostValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint): void
    {
        if (null !== $value) {
            if (!is_float($value)) {
                $this->context->addViolation('Cost must be a float.');
            } elseif ($value !== round($value, 2)) {
                $this->context->addViolation('Cost must have a precision of 2.');
            }
        }
    }
}
