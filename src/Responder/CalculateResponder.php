<?php
declare(strict_types=1);
namespace App\Responder;

use App\Api\Request\PaymentRequest;
use App\Domain\Service\CalculatePriceService;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 *
 */
final class CalculateResponder extends AbstractType
{
    /**
     * @param CalculatePriceService $service
     */
    public function __construct(
        private CalculatePriceService $service,
    ){}

    /**
     * @param PaymentRequest $request
     * @return JsonResponse
     */
    public function __invoke(PaymentRequest $request): JsonResponse
    {
        $price = $this->service->calculatePrice(
            $request->taxNumber,
            (int)$request->product,
            $request->couponCode
        );

        return (new JsonResponse([
            'status' => 'ok',
            'message' => $price
        ], Response::HTTP_OK));
    }
}
