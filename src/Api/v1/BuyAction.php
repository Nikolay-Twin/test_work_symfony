<?php
declare(strict_types=1);
namespace App\Api\v1;

use App\Api\Request\PaymentRequest;
use App\Responder\BuyResponder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/buy', name: 'buy', methods: 'PUT')]
class BuyAction extends AbstractController
{
    /**
     * @param PaymentRequest $request
     * @param BuyResponder $responder
     * @return JsonResponse
     */
    public function __invoke(PaymentRequest $request, BuyResponder $responder): JsonResponse
    {
        return $responder($request);
    }
}