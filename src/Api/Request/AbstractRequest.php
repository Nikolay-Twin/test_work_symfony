<?php
declare(strict_types=1);
namespace App\Api\Request;

use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 *
 */
abstract class AbstractRequest
{
    private Request $request;

    /**
     * @param ValidatorInterface $validator
     */
    public function __construct(protected ValidatorInterface $validator)
    {
        $this->createRequest();
        $this->populate();

        if ($this->autoValidateRequest()) {
            $this->validate();
        }
    }

    /**
     * @return void
     */
    public function validate(): void
    {
        $errors = $this->validator->validate($this);
        $messages = ['message' => 'validation_failed', 'errors' => []];

        foreach ($errors as $message) {
            $messages['errors'][] = [
                'property' => $message->getPropertyPath(),
                'value' => $message->getInvalidValue(),
                'message' => $message->getMessage(),
            ];
        }

        if (count($messages['errors']) > 0) {
            $response = new JsonResponse($messages, 400);
            $response->send();
            exit;
        }
    }

    /**
     * @return void
     */
    public function createRequest(): void
    {
        $this->request = Request::createFromGlobals();
    }

    /**
     * @return void
     */
    protected function populate(): void
    {
        $requestFields = $this->request->toArray();

        foreach (get_object_vars($this) as $attribute => $_) {
            if (isset($requestFields[$attribute])) {
                $this->{$attribute} = $requestFields[$attribute];
            }
        }
    }

    /**
     * @return bool
     */
    protected function autoValidateRequest(): bool
    {
        return true;
    }
}
