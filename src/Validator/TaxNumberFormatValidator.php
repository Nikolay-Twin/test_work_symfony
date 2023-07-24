<?php
declare(strict_types=1);
namespace App\Validator;

use App\Helper\TaxHelper;
use Symfony\Component\Validator\ConstraintValidator;

/**
 *
 */
class TaxNumberFormatValidator extends ConstraintValidator
{
    /**
     * @param $taxNumber
     * @param mixed|null $constraint
     * @return void
     */
    public function validate($taxNumber, mixed $constraint = null): void
    {
        if (false === TaxHelper::checkTaxNumberFormat($taxNumber)) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}