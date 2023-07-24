<?php
declare(strict_types=1);
namespace App\Api\Request;

use Symfony\Component\Validator\Constraints as Assert;
use App\Validator as Custom;
/**
 *
 */
class PaymentRequest extends AbstractRequest
{
    /**
     * @var $product
     */
    #[Assert\NotBlank(
        message: 'Product not selected',
    )]
    public $product;

    /**
     * @var $taxNumber
     */
    #[Assert\NotBlank(
        message: 'Taxnumber not entered',
    )]
    #[Assert\Type('string')]
    #[Custom\TaxNumberFormat]
    public $taxNumber = '';

    /**
     * @var $couponCode
     */
    #[Custom\PresenceCoupon]
    public $couponCode;

    /**
     * @var $paymentProcessor
     */
    #[Assert\NotBlank(
        message: 'Payment processor not selected',
    )]
    public $paymentProcessor;

    #[Assert\integer]
    public $money;
}