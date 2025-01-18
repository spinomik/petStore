<?php

namespace App\Services;

use App\Enums\PetErrorEnum;
use App\Enums\PetOperationEnum;
use Illuminate\Http\Client\Response;

class ApiErrorHandler
{
    public static function handleError(Response $response, PetOperationEnum $operation)
    {
        $statusCode = (int) $response->status();
        if ($statusCode === 200) {
            return null;
        }

        if ($operation === PetOperationEnum::EXISTS && $statusCode === 404) {
            return null;
        }

        $errors = PetErrorEnum::getByOperation($operation);

        if (isset($errors[$statusCode])) {
            throw new \Exception($errors[$statusCode]->getMessage());
        }

        throw new \Exception("Unknown error occurred for operation: {$operation->value}, status code: {$statusCode}");
    }
}
