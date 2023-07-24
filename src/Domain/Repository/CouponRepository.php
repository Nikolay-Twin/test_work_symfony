<?php
declare(strict_types=1);
namespace App\Domain\Repository;

use App\Domain\Entity\Coupon;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Coupon>
 *
 * @method Coupon|null find($id, $lockMode = null, $lockVersion = null)
 * @method Coupon|null findOneBy(array $criteria, array $orderBy = null)
 * @method Coupon[]    findAll()
 * @method Coupon[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CouponRepository extends ServiceEntityRepository
{
    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Coupon::class);
    }
}
