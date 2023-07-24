<?php
declare(strict_types=1);
namespace App\Tests\Domain;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 *
 */
abstract class AbstractDomainTestCase extends KernelTestCase
{
    protected static EntityManagerInterface $entityManager;

    /**
     * @return void
     */
    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        static::bootKernel();
        static::$entityManager = static::$kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }
}
