<?php

namespace App\Enums;

enum PetOperationEnum: string
{
    case CREATE = 'create';
    case GET = 'get';
    case UPDATE = 'update';
    case DELETE = 'delete';
    case EXISTS = 'exists';
}
