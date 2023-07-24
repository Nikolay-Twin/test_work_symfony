<?php
declare(strict_types=1);
namespace App\Api\v1;

use App\Api\Request\PaymentRequest;
use App\Responder\CalculateResponder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/calculate', name: 'calculate', methods: 'PUT')]
class CalculateAction extends AbstractController
{
    /**
     * @param PaymentRequest $request
     * @param CalculateResponder $responder
     * @return JsonResponse
     */
    public function __invoke(PaymentRequest $request, CalculateResponder $responder): JsonResponse
    {
        return $responder($request);
    }
}