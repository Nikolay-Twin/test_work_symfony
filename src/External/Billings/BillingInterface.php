<?php
declare(strict_types=1);
namespace App\External\Billings;

/**
 *
 */
interface BillingInterface
{
    /**
     * @param int $price
     * @return bool|string
     */
    public function pay(int $price): bool|string;

    /**
     * @return array
     */
    public function getErrors(): array;

    /**
     * @return bool
     */
    public function success(): bool;
}