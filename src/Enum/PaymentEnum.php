<?php
declare(strict_types=1);
namespace App\Enum;

class PaymentEnum
{
    public const GERMANY = 'DE';
    public const ITALY   = 'IT';
    public const GREECE  = 'GR';
    public const FRANCE  = 'FR';

    public const FIXED    = 1;
    public const PERCENT  = 2;

    public const TAX = [
        self::GERMANY => 19,
        self::ITALY   => 22,
        self::GREECE  => 24,
        self::FRANCE  => 20,
    ];

    public const TAX_NUMBER_TEMPLATES = [
        self::GERMANY => 'DE\d{9}',
        self::ITALY   => 'IT\d{11}',
        self::GREECE  => 'GR\d{9}',
        self::FRANCE  => 'FR[A-Z]{2}\d{9}',
    ];

    public const DISCOUNT = [
        self::FIXED    => 2,
        self::PERCENT  => 6,
    ];
}