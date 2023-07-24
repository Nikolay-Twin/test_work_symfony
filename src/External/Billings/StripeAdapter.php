<?php
declare(strict_types=1);
namespace App\External\Billings;

use StripePaymentProcessor;

/**
 *
 */
final class StripeAdapter implements BillingInterface
{
    private StripePaymentProcessor $billing;
    private array $errors = [];

    /**
     *
     */
    public function __construct()
    {
        $this->billing = new StripePaymentProcessor();
    }

    /**
     * @param int $price
     * @return bool
     */
    public function pay(int $price): bool
    {
        if (!$this->billing->processPayment($price)) {
            $this->errors[]['message'] = 'Very little money';
            return false;
        }
        return true;
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @return bool
     */
    public function success(): bool
    {
        return !count($this->getErrors());
    }
}