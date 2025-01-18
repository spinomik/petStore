<?php

namespace App\Repositories\Contracts;

use App\Models\Pet;
use Illuminate\Http\Client\Response;

interface PetRepositoryInterface
{
    public function createPet(Pet $pet): Response;
    public function getPet(int $id): Response;
    public function updatePet(Pet $pet): Response;
    public function deletePet(int $id): array;
    public function existsPet(int $id): bool;
}
