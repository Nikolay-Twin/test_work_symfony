<?php
declare(strict_types=1);
namespace App\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class TaxNumberFormat extends Constraint
{
    public $message = 'Invalid taxnumber format';
}