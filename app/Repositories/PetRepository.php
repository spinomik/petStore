<?php

namespace App\Repositories;

use App\Repositories\Contracts\PetRepositoryInterface;
use App\Services\ApiErrorHandler;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use App\Services\PetAdapter;
use App\Enums\PetOperationEnum;
use App\Models\Pet;

class PetRepository implements PetRepositoryInterface
{
    private string $apiUrl;
    private string $apiKey;

    public function __construct()
    {
        $this->apiUrl = config('services.api.url');
        $this->apiKey = config('services.api.key');
    }

    public function createPet(Pet $pet): Response
    {
        $response = Http::post("{$this->apiUrl}", PetAdapter::toArray($pet));
        ApiErrorHandler::handleError($response, PetOperationEnum::CREATE);

        return $response;
    }

    public function getPet(int $id): Response
    {
        $response = Http::get("{$this->apiUrl}/{$id}");
        ApiErrorHandler::handleError($response, PetOperationEnum::GET);

        return $response;
    }

    public function updatePet(Pet $pet): Response
    {
        $response = Http::put("{$this->apiUrl}",  PetAdapter::toArray($pet));
        ApiErrorHandler::handleError($response, PetOperationEnum::UPDATE);

        return $response;
    }

    public function deletePet(int $id): array
    {
        $response = Http::withHeaders([
            'accept' => 'application/json',
            'api_key' => $this->apiKey,
        ])->delete("{$this->apiUrl}/{$id}");
        ApiErrorHandler::handleError($response, PetOperationEnum::DELETE);
        return $response->json();
    }

    public function existsPet(int $id): bool
    {
        $response = Http::get("{$this->apiUrl}/{$id}");

        ApiErrorHandler::handleError($response, PetOperationEnum::EXISTS);

        return match ($response->getStatusCode()) {
            200 => true,
            404 => false,
            default => throw new \Exception('Błąd podczas sprawdzania istnienia zwierzaka'),
        };
    }
}
