<?php
declare(strict_types=1);
namespace App\Tests\Domain;

use App\Domain\Service\CalculatePriceService;
use DomainException;

/**
 *
 */
class CalculateServiceTest extends AbstractDomainTestCase
{
    private CalculatePriceService $service;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->service = new CalculatePriceService(static::$entityManager);
    }

    /**
     * Calculate
     */
    public function testCalculateService(): void
    {
        /*  GERMANY  */
        $price = $this->service->calculatePrice('DE123456789', 1);
        $this->assertEquals(119, $price);
        /* ITALY  */
        $price = $this->service->calculatePrice('IT12345678901', 1);
        $this->assertEquals(122, $price);
        /* GREECE  */
        $price = $this->service->calculatePrice('GR123456789', 1);
        $this->assertEquals(124, $price);
        /* FRANCE  */
        $price = $this->service->calculatePrice('FRAB123456789', 1);
        $this->assertEquals(120, $price);
    }
}