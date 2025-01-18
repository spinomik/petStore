<?php

namespace App\Enums;

enum PetCategoryEnum: string
{
    case DOG = '1:Dog';
    case CAT = '2:Cat';
    case BIRD = '3:Bird';
    case REPTILE = '4:Reptile';
    case FISH = '5:Fish';
    case SMALL_ANIMAL = '6:Small Animal';
    case OTHER = '7:Other';

    public function getId(): int
    {
        return (int) explode(':', $this->value)[0];
    }

    public static function fromId(int $id): ?self
    {
        foreach (self::cases() as $case) {
            if ($case->getId() === $id) {
                return $case;
            }
        }
        return self::OTHER;
    }

    public function getName(): string
    {
        return explode(':', $this->value)[1];
    }

    public static function getAll(): array
    {
        $categories = [];
        foreach (self::cases() as $case) {
            $categories[$case->getId()] = $case->getName();
        }
        return $categories;
    }
}
