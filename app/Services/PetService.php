<?php

namespace App\Services;

use App\Models\Pet;
use App\Repositories\Contracts\PetRepositoryInterface;
use Illuminate\Http\Client\Response;


class PetService
{
    private PetRepositoryInterface $petRepository;

    public function __construct(PetRepositoryInterface $petRepository)
    {
        $this->petRepository = $petRepository;
    }

    public function createPet(Pet $pet): Response
    {
        return $this->petRepository->createPet($pet);
    }

    public function getPet(int $id): Pet
    {
        $response = $this->petRepository->getPet($id);
        $pet = PetAdapter::fromApi($response);
        return $pet;
    }

    public function updatePet(Pet $pet): Response
    {
        return $this->petRepository->updatePet($pet);
    }

    public function deletePet(int $id): array
    {
        return $this->petRepository->deletePet($id);
    }

    public function existsPet(int $id): bool
    {

        return $this->petRepository->existsPet($id);
    }
}
