<?php
declare(strict_types=1);
namespace App\Responder;

use App\Api\Request\PaymentRequest;
use App\External\Billings\BillingFactory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 *
 */
final class BuyResponder extends AbstractType
{

    /**
     * @param PaymentRequest $request
     * @return JsonResponse
     */
    public function __invoke(PaymentRequest $request): JsonResponse
    {
        $billing = BillingFactory::make($request->paymentProcessor);
        $billing->pay((int)$request->money);

        if ($billing->success()) {
            return new JsonResponse([
                'status' => 'ok',
                'message' => 'Payment completed',
            ]);
        }

        return new JsonResponse([
            'message' => 'billing_errors',
            'errors' => $billing->getErrors()
        ], JsonResponse::HTTP_BAD_REQUEST);
    }
}
