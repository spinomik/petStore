<?php

namespace App\Repositories\Contracts;

interface PetRepositoryInterface
{
    public function createPet(array $data): array;
    public function getPet(int $id): array;
    public function updatePet(int $id, array $data): array;
    public function deletePet(int $id): array;
    public function existsPet(int $id): bool;
}
