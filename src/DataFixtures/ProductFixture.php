<?php
declare(strict_types=1);
namespace App\DataFixtures;

use App\Domain\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\Query\ResultSetMapping;
/**
 * Создание валют.
 */
final class ProductFixture extends Fixture
{
    private const PRODUCTS = [
        'Iphone'   => 100,
        'Наушники' => 20,
        'Чехол'    => 10
    ];

    /**
     * @inheritdoc
     */
    public function load(ObjectManager $manager): void
    {
        $map = new ResultSetMapping();
        $manager->createNativeQuery('ALTER SEQUENCE product_id_seq RESTART WITH 1', $map)
            ->execute();
        $manager->createNativeQuery('TRUNCATE TABLE product RESTART IDENTITY', $map)
            ->execute();

        foreach (self::PRODUCTS as $name => $price) {
            $product = (new Product())->setName($name)->setPrice($price);
            $manager->persist($product);
        }

        $manager->flush();
    }
}
