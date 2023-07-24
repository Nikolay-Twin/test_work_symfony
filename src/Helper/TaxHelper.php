<?php
declare(strict_types=1);
namespace App\Helper;

use App\Enum\PaymentEnum;
use RuntimeException;

/**
 *
 */
class TaxHelper
{
    /**
     * @param string|null $taxNumber
     * @return bool
     */
    public static function checkTaxNumberFormat(?string $taxNumber): bool
    {
        if (!empty($taxNumber)) {
            foreach (PaymentEnum::TAX_NUMBER_TEMPLATES as $template) {
                if (preg_match("/^$template$/", $taxNumber)) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * @param string $taxNumber
     * @return int|false
     */
    public static function getTaxByNumber(string $taxNumber): int|false
    {
        $country = substr($taxNumber, 0, 2);
        return PaymentEnum::TAX[$country] ?? throw new RuntimeException('Tax not found');
    }
}