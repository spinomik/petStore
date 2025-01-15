<?php

namespace App\Enums;

enum PetErrorEnum: string
{
    case INVALID_INPUT = 'Nieprawidłowe dane wejściowe ';
    case INVALID_ID_SUPPLIED = 'Niepoprawne ID';
    case PET_NOT_FOUND = 'Zwierz nie znaleziony';
    case VALIDATION_EXCEPTION = 'Błąd walidacji';

    public static function getByOperation(PetOperationEnum $operation): array
    {
        return match ($operation) {
            PetOperationEnum::CREATE => [
                405 => self::INVALID_INPUT,
            ],
            PetOperationEnum::UPDATE => [
                400 => self::INVALID_ID_SUPPLIED,
                404 => self::PET_NOT_FOUND,
                405 => self::VALIDATION_EXCEPTION,
            ],
            PetOperationEnum::GET  => [
                400 => self::INVALID_ID_SUPPLIED,
                404 => self::PET_NOT_FOUND,
            ],
            PetOperationEnum::DELETE => [
                400 => self::INVALID_ID_SUPPLIED,
                404 => self::PET_NOT_FOUND,
            ],
            default => [],
        };
    }

    public function getMessage(): string
    {
        return $this->value;
    }
}
