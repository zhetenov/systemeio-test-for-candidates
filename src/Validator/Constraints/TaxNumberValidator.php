<?php

declare(strict_types=1);

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Class TaxNumberValidator.
 */
final class TaxNumberValidator extends ConstraintValidator
{
    /**
     * @param $value
     * @param Constraint $constraint
     * @return void
     */
    public function validate($value, Constraint $constraint)
    {
        if (null === $value || '' === $value) {
            return;
        }
        if (!$this->isTaxNumberValid($value)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ string }}', $value)
                ->addViolation();
        }
    }

    /**
     * @param string $taxNumber
     * @return bool
     */
    private function isTaxNumberValid(string $taxNumber): bool
    {
        return preg_match('/^([A-Z]{2})\d+$/', $taxNumber) === 1;
    }
}
