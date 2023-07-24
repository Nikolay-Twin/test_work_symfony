<?php
declare(strict_types=1);
namespace App\Validator;

use App\Domain\Entity\Coupon;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\ConstraintValidator;

/**
 *
 */
class PresenceCouponValidator extends ConstraintValidator
{
    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(protected EntityManagerInterface $entityManager){}

    /**
     * @param $couponCode
     * @param mixed $constraint
     * @return void
     */
    public function validate($couponCode, mixed $constraint): void
    {
        if ('' === $couponCode || null === $couponCode) {
            return;
        }

        if (3 !== strlen((string)$couponCode)) {
            $this->context->buildViolation($constraint->exactMessage)
                ->addViolation();
            return;
        }

        $result = $this->entityManager
            ->getRepository(Coupon::class)
            ->count(['code' => $couponCode]);

        if (empty($result)) {
            $this->context->buildViolation($constraint->notFoundMessage)
                ->addViolation();
        }
    }
}