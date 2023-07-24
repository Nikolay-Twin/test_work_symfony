<?php
declare(strict_types=1);
namespace App\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class PresenceCoupon extends Constraint
{
    public $exactMessage = 'Your coupon must be at least 3 characters long';
    public $notFoundMessage = 'Coupon not found';
}