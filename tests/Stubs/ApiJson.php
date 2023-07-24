<?php
declare(strict_types=1);
namespace App\Tests\Stubs;

/**
 *
 */
class ApiJson
{
    /**
     * @return string[]
     */
    public static function getData(): array
    {
        return [
            'product' => 1,
            'taxNumber' => 'GR123456789',
            'couponCode' => 'D15',
            'paymentProcessor' => 'paypal',
        ];
    }

    /**
     * @return string[]
     */
    public static function getBadData(): array
    {
        return [
            'product' => 'Iphone',
            'taxNumber' => '100',
            'couponCode' => '55555',
            'paymentProcessor' => 'webmoney',
        ];
    }
}