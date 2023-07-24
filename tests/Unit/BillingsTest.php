<?php
declare(strict_types=1);
namespace App\Tests\Unit;

use App\External\Billings\BillingFactory;
use App\External\Billings\BillingInterface;
use PHPUnit\Framework\TestCase;


class BillingsTest extends TestCase
{
    /**
     * Paypal
     */
    public function testPaypal(): void
    {
        $paypal = BillingFactory::make('paypal');
        $this->assertInstanceOf(BillingInterface::class, $paypal);

        $this->assertTrue($paypal->pay(100));
        $this->assertTrue($paypal->success());

        $this->assertFalse($paypal->pay(101));
        $this->assertFalse($paypal->success());
    }

    /**
     * Stripe
     */
    public function testStripe(): void
    {
        $stripe = BillingFactory::make('stripe');
        $this->assertInstanceOf(BillingInterface::class, $stripe);

        $this->assertTrue($stripe->pay(10));
        $this->assertTrue($stripe->success());

        $this->assertFalse($stripe->pay(9));
        $this->assertFalse($stripe->success());
    }
}