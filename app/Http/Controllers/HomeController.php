<?php

namespace App\Http\Controllers;

use App\Enums\PetCategoryEnum;
use App\Enums\PetStatusEnum;

class HomeController extends Controller
{
    public function index()
    {
        return view('petstore');
    }
}
