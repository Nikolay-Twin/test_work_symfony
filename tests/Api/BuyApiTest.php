<?php
declare(strict_types=1);
namespace App\Tests\Api;

use App\Tests\Stubs\ApiJson;

/**
 *
 */
class BuyApiTest extends AbstractApiTestCase
{
    /**
     * @param array $data
     * @return void
     */
    private function send(array $data = []): void
    {
        $data = array_merge(ApiJson::getData(), $data);
        static::$client->sendPut('/api/v1/buy', json_encode($data));
    }

    /**
     * Paypal
     */
    public function testPaypal(): void
    {
        $this->send(['paymentProcessor' => 'paypal', 'money' => 100]);
        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(200);
        $this->assertJsonEquals([
            'status' => 'ok',
            'message' => 'Payment completed',
        ]);
    }

    /**
     * Stripe
     */
    public function testStripe(): void
    {
        $this->send(['paymentProcessor' => 'stripe', 'money' => 10]);
        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(200);
        $this->assertJsonEquals([
            'status' => 'ok',
            'message' => 'Payment completed',
        ]);
    }

    /**
     * Fail
     */
    public function testBadData(): void
    {
        $this->send(ApiJson::getBadData());
        $this->assertResponseStatusCodeSame(400);
        $this->assertJsonContains('validation_failed');
    }

    /**
     * Fail
     */
    public function testBadPayPaypal(): void
    {
        $this->send(['paymentProcessor' => 'paypal', 'money' => 500]);
        $this->assertResponseStatusCodeSame(400);
        $this->assertJsonContains('billing_errors');
    }

    /**
     * Fail
     */
    public function testBadPaySprite(): void
    {
        $this->send(['paymentProcessor' => 'stripe', 'money' => 5]);
        $this->assertResponseStatusCodeSame(400);
        $this->assertJsonContains('billing_errors');
    }
}
