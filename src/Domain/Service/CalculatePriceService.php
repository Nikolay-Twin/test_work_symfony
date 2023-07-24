<?php
declare(strict_types=1);
namespace App\Domain\Service;

use App\Domain\Entity\Coupon;
use App\Domain\Entity\Product;
use App\Enum\PaymentEnum;
use App\Helper\TaxHelper;
use Doctrine\ORM\EntityManagerInterface;
use DomainException;

/**
 *
 */
class CalculatePriceService
{
    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(private EntityManagerInterface $entityManager){}

    /**
     * @param string $taxNumber
     * @param int $product
     * @return float
     */
    public function calculatePrice(string $taxNumber, int $productId, string $couponCode = ''): float
    {
        try {
            $tax = TaxHelper::getTaxByNumber($taxNumber);

            $price = $this->entityManager
                ->getRepository(Product::class)
                ->find($productId)
                ->getPrice();


            if (!empty($couponCode)) {
                $type = $this->entityManager
                    ->getRepository(Coupon::class)
                    ->findOneBy(['code' => $couponCode])
                    ->getType();

                $price = match ($type) {
                    PaymentEnum::FIXED => $price - PaymentEnum::DISCOUNT[PaymentEnum::FIXED],
                    PaymentEnum::PERCENT => $price - ($price / 100 * PaymentEnum::DISCOUNT[PaymentEnum::PERCENT]),
                    default => 0
                };
            }

            return round(($price / 100 * $tax + $price), 2);

        } catch (\Throwable $t) {
            /** @TODO THIS LOG */
            throw new DomainException('Calculate failed');
        }
    }
}