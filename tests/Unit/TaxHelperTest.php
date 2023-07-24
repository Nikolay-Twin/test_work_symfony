<?php
declare(strict_types=1);
namespace App\Tests\Unit;

use App\Helper\TaxHelper;
use PHPUnit\Framework\TestCase;
use RuntimeException;

/**
 *
 */
class TaxHelperTest extends TestCase
{
    /**
     * Germany
     */
    public function testGeBadNumbers(): void
    {
        $result = TaxHelper::checkTaxNumberFormat('AA123456789');
        $this->assertFalse($result);
        $result = TaxHelper::checkTaxNumberFormat('GE123');
        $this->assertFalse($result);
        $result = TaxHelper::checkTaxNumberFormat('GE1234567890901');
        $this->assertFalse($result);
        $result = TaxHelper::checkTaxNumberFormat('GEAB123456789');
        $this->assertFalse($result);
    }

    /**
     * Italy
     */
    public function testItBadNumbers(): void
    {
        $result = TaxHelper::checkTaxNumberFormat('AA123456789');
        $this->assertFalse($result);
        $result = TaxHelper::checkTaxNumberFormat('IT123');
        $this->assertFalse($result);
        $result = TaxHelper::checkTaxNumberFormat('IT123456789090123');
        $this->assertFalse($result);
        $result = TaxHelper::checkTaxNumberFormat('ITAB123456789');
        $this->assertFalse($result);
    }

    /**
     * Greece
     */
    public function testGrBadNumbers(): void
    {
        $result = TaxHelper::checkTaxNumberFormat('AA123456789');
        $this->assertFalse($result);
        $result = TaxHelper::checkTaxNumberFormat('GR123');
        $this->assertFalse($result);
        $result = TaxHelper::checkTaxNumberFormat('GR1234567890901');
        $this->assertFalse($result);
        $result = TaxHelper::checkTaxNumberFormat('GRAB123456789');
        $this->assertFalse($result);
    }

    /**
     * France
     */
    public function testFrBadNumbers(): void
    {
        $result = TaxHelper::checkTaxNumberFormat('AA123456789');
        $this->assertFalse($result);
        $result = TaxHelper::checkTaxNumberFormat('FR123');
        $this->assertFalse($result);
        $result = TaxHelper::checkTaxNumberFormat('FR1234567890901');
        $this->assertFalse($result);
        $result = TaxHelper::checkTaxNumberFormat('FRAB1234567890');
        $this->assertFalse($result);
        $result = TaxHelper::checkTaxNumberFormat('FRABCD1234567');
        $this->assertFalse($result);
    }

    /**
     * Correct
     */
    public function testCorrectNumbers(): void
    {
        $result = TaxHelper::checkTaxNumberFormat('DE123456789');
        $this->assertTrue($result);
        $result = TaxHelper::checkTaxNumberFormat('IT12345678901');
        $this->assertTrue($result);
        $result = TaxHelper::checkTaxNumberFormat('GR123456789');
        $this->assertTrue($result);
        $result = TaxHelper::checkTaxNumberFormat('FRAB123456789');
        $this->assertTrue($result);
    }

    /**
     * TaxByNumber
     */
    public function testTaxByNumber(): void
    {
        $result = TaxHelper::getTaxByNumber('DE123456789');
        $this->assertEquals(19, $result);
        $result = TaxHelper::getTaxByNumber('IT12345678901');
        $this->assertEquals(22, $result);
        $result = TaxHelper::getTaxByNumber('GR123456789');
        $this->assertEquals(24, $result);
        $result = TaxHelper::getTaxByNumber('FRAB123456789');
        $this->assertEquals(20, $result);
    }

    /**
     * Exception
     */
    public function testTaxByNumberException(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Tax not found');
        TaxHelper::getTaxByNumber('DUMMY');
    }
}
