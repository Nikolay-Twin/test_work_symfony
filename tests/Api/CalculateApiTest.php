<?php
declare(strict_types=1);
namespace App\Tests\Api;

use App\Tests\Stubs\ApiJson;

/**
 *
 */
class CalculateApiTest extends AbstractApiTestCase
{
    /**
     * @param array $data
     * @return void
     */
    private function send(array $data = []): void
    {
        $data = array_merge(ApiJson::getData(), $data);
        static::$client->sendPut('/api/v1/calculate', json_encode($data));
    }

    /**
     * Paypal
     */
    public function testPaypal(): void
    {
        $this->send(['paymentProcessor' => 'paypal']);
        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(200);
        $this->assertJsonEquals([
            'status' => 'ok',
            'message' => 116.56
        ]);
    }

    /**
     * Stripe
     */
    public function testStripe(): void
    {
        $this->send(['paymentProcessor' => 'stripe']);
        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(200);
        $this->assertJsonEquals([
            'status' => 'ok',
            'message' => 116.56
        ]);
    }
}
