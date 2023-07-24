<?php
declare(strict_types=1);
namespace App\External\Billings;

use App\Enum\BillingsEnum;
use DomainException;

/**
 *
 */
class BillingFactory
{
    /**
     * @param string $billingName
     * @return false|BillingInterface
     */
    public static function make(string $billingName): false|BillingInterface
    {
        if (in_array($billingName, BillingsEnum::BILLINGS)) {
            $class = self::findClass($billingName);
            if (!BillingInterface::class instanceof $class) {
                return new $class();
            } else {
                throw new DomainException(
                    sprintf('Class %s does not implement %s', $class, BillingInterface::class)
                );
            }
        }
        throw new DomainException(
            sprintf('Billing %s not registered in %s', $billingName, BillingsEnum::class)
        );
    }

    /**
     * @param string $className
     * @return string
     */
    protected static function findClass(string $className): string
    {
        $className = __NAMESPACE__ .'\\'. ucfirst($className);
        return match (true) {
            class_exists($className) => $className,
            class_exists($className . 'Adapter') => $className . 'Adapter',
                default => throw new DomainException(
                    sprintf('Class %s not found in %s', $className, dirname(__DIR__))
                )
       };
    }
}