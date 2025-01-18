<?php

namespace App\Services;

use App\Enums\PetCategoryEnum;
use App\Enums\PetStatusEnum;
use App\Models\Pet;
use Illuminate\Http\Client\Response;

class PetAdapter
{
    public static function fromApi(Response | array $source): Pet
    {
        $data = $source instanceof Response ? $source->json() : $source;
        $data = self::validateData($data);
        return new Pet(
            id: $data['id'],
            categoryId: $data['categoryId'],
            name: $data['name'],
            photoUrls: $data['photoUrls'],
            status: $data['status']
        );
    }

    private static function validateData(array $data): array
    {
        $notFoundImg = 'https://img.freepik.com/free-vector/glitch-background_23-2148068933.jpg?t=st=1737052647~exp=1737056247~hmac=fd6455e08e19d525768d034f0d6af76f40f287d7385adfd7ae35b9e0c7688f65&w=826';

        $id = isset($data['id']) && is_numeric($data['id']) ? (int) $data['id'] : null;
        if (isset($data['category'])) {
            if (is_array($data['category']) && isset($data['category']['id']) && is_numeric($data['category']['id'])) {
                $categoryId = (int) $data['category']['id'];
            } elseif (is_numeric($data['category'])) {
                $categoryId = (int) $data['category'];
            }
        }
        $validCategory = PetCategoryEnum::fromId($categoryId ?? 0)->getId();
        $name = !empty($data['name']) ? $data['name'] : 'Unknown';
        $photoUrls = isset($data['photoUrls']) && is_array($data['photoUrls']) && !empty($data['photoUrls'])
            ? $data['photoUrls']
            : [$notFoundImg];

        $status = in_array($data['status'] ?? '', PetStatusEnum::getAll(), true)
            ? $data['status']
            : PetStatusEnum::AVAILABLE->value;

        return [
            'id' => $id,
            'categoryId' => $validCategory,
            'name' => $name,
            'photoUrls' => $photoUrls,
            'status' => $status,
        ];
    }

    public static function toArray(Pet $pet): array
    {
        return [
            'id' => $pet->getId(),
            'category' => [
                'id' => $pet->getCategoryId(),
                'name' => PetCategoryEnum::fromId($pet->getCategoryId())->getName(),
            ],
            'name' => $pet->getName(),
            'photoUrls' => $pet->getPhotoUrls(),
            'status' => $pet->getStatus(),
        ];
    }
}
