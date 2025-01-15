<?php

namespace App\Services;

use App\Repositories\Contracts\PetRepositoryInterface;

class PetService
{
    private PetRepositoryInterface $petRepository;

    public function __construct(PetRepositoryInterface $petRepository)
    {
        $this->petRepository = $petRepository;
    }

    public function createPet(array $data): array
    {
        return $this->petRepository->createPet($data);
    }

    public function getPet(int $id): array
    {
        return $this->petRepository->getPet($id);
    }

    public function updatePet(int $id, array $data): array
    {
        return $this->petRepository->updatePet($id, $data);
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
