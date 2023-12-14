<?php

declare(strict_types=1);

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * Class TaxNumber.
 */
#[\Attribute] class TaxNumber extends Constraint
{
    public string $message = 'The tax number "{{ string }}" is not a valid tax number.';

    public function validatedBy(): string
    {
        return static::class.'Validator';
    }
}
