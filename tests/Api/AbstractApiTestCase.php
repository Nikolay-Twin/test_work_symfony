<?php
declare(strict_types=1);
namespace App\Tests\Api;

use App\Tests\JsonAssertionsTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\AbstractBrowser;

/**
 *
 */
abstract class AbstractApiTestCase extends WebTestCase
{
    use JsonAssertionsTrait;

    protected static AbstractBrowser $client;

    /**
     * @return void
     */
    public function setUp(): void
    {
        static::$client = self::createClient()
            ->setHost(getenv('CURL_HOST'))
            ->withHeader('Content-Type', 'application/x-www-form-urlencoded')
            ->withHeader('X-Requested-With', 'XMLHttpRequest');
    }

}