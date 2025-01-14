<?php

namespace App\Repositories;

use App\Repositories\Contracts\PetRepositoryInterface;
use Illuminate\Support\Facades\Http;

class PetRepository implements PetRepositoryInterface
{
    private string $apiUrl;
    private string $apiKey;

    public function __construct()
    {
        $this->apiUrl = config('services.api.url');
        $this->apiKey = config('services.api.key');
    }

    public function createPet(array $data): array
    {
        $response = Http::post("{$this->apiUrl}", $data);

        return $response->json();
    }

    public function getPet(int $id): array
    {
        $response = Http::get("{$this->apiUrl}/{$id}");

        return $response->json();
    }

    public function updatePet(int $id, array $data): array
    {
        $response = Http::put("{$this->apiUrl}", $data);

        return $response->json();
    }

    public function deletePet(int $id): array
    {
        $response = Http::withHeaders([
            'accept' => 'application/json',
            'api_key' => $this->apiKey,
        ])->delete("{$this->apiUrl}/{$id}");
        return $response->json();
    }
}
