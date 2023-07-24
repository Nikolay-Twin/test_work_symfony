<?php
declare(strict_types=1);
namespace App\External\Billings;

use PaypalPaymentProcessor;
use Exception;

/**
 *
 */
final class PaypalAdapter implements BillingInterface
{
    private PaypalPaymentProcessor $billing;
    private array $errors = [];

    /**
     *
     */
    public function __construct()
    {
        $this->billing = new PaypalPaymentProcessor();
    }

    /**
     * @param int $price
     * @return bool
     */
    public function pay(int $price): bool
    {
        try {
            $this->billing->pay($price);
            return true;
        } catch (Exception $e) {
            $this->errors[]['message'] = $e->getMessage();
            return false;
        }
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