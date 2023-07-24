<?php
declare(strict_types=1);
namespace App\DataFixtures;

use App\Domain\Entity\Coupon;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\Persistence\ObjectManager;

/**
 * Создание валют.
 */
final class CouponFixture extends Fixture
{
    private const COUPONS = [
        'A1O' => 1,
        'D15' => 2,
    ];

    /**
     * @inheritdoc
     */
    public function load(ObjectManager $manager): void
    {
        $map = new ResultSetMapping();
        $manager->createNativeQuery('ALTER SEQUENCE coupon_id_seq RESTART WITH 1', $map)
            ->execute();
        $manager->createNativeQuery('TRUNCATE TABLE coupon RESTART IDENTITY', $map)
            ->execute();

        foreach (self::COUPONS as $code => $type) {
            $coupon = (new Coupon())->setCode($code)->setType($type);
            $manager->persist($coupon);
        }

        $manager->flush();
    }
}
