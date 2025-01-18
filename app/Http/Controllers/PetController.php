<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PetService;
use App\Enums\PetCategoryEnum;
use App\Enums\PetStatusEnum;
use App\Services\PetAdapter;

class PetController extends Controller
{
    private PetService $petService;

    public function __construct(PetService $petService)
    {
        $this->petService = $petService;
    }

    public function create(Request $request)
    {
        $data = json_decode($request->input('data'), true);
        $categories = PetCategoryEnum::getAll();
        $statuses = PetStatusEnum::getAll();
        if ($data) {

            return view('pets.create', compact('data', 'categories', 'statuses'));
        }

        return view(
            'pets.create',
            compact('categories', 'statuses')
        );
    }

    public function store(Request $request)
    {
        try {
            $pet = PetAdapter::fromApi($request->all());
            $petExists = $this->petService->existsPet($pet->getId());
            if ($petExists && !$request->boolean('overwrite')) {

                return redirect()
                    ->route('pets.confirmOverwrite', [
                        'id' => $pet->getId(),
                        'newAnimal' => PetAdapter::toArray($pet),
                    ])
                    ->with('warning', 'Zwierzak o podanym ID już istnieje. Czy chcesz go nadpisać?');
            }
            $this->petService->createPet($pet);

            return redirect()->route('home')->with(
                'success',
                $petExists ? 'Zwierz został nadpisany pomyślnie!' : 'Zwierz dodany pomyślnie!'
            );
        } catch (\Exception $e) {

            return redirect()->route('home')->with('error', $e->getMessage());
        }
    }

    public function search(Request $request)
    {
        $id = $request->input('id');
        try {
            $pet = $this->petService->getPet($id);
            $pet->categoryName = PetCategoryEnum::fromId($pet->getCategoryId())->getName();

            return view('pets.show', [
                'pet' => $pet
            ]);
        } catch (\Exception $e) {

            return redirect()->route('home')->with('error', $e->getMessage());
        }
    }

    public function edit(int $id)
    {
        try {
            $pet = $this->petService->getPet($id);
        } catch (\Exception $e) {

            return redirect()->route('home')->with('error', $e->getMessage());
        }

        return view('pets.edit', [
            'pet' => $pet,
            'categories' => PetCategoryEnum::getAll(),
            'statuses' => PetStatusEnum::getAll()
        ]);
    }

    public function update(Request $request)
    {
        try {
            $pet = PetAdapter::fromApi($request->all());
            $this->petService->updatePet($pet);

            return redirect()->route('home')->with('success', 'Zwierz zaktualizowany!');
        } catch (\Exception $e) {

            return redirect()->route('home')->with('error', $e->getMessage());
        }
    }

    public function destroy(int $id)
    {
        try {
            $this->petService->getPet($id);
            $this->petService->deletePet($id);

            return redirect()->route('home')->with('success', 'Zwierz został usunięty!');
        } catch (\Exception $e) {

            return redirect()->route('home')->with('error', $e->getMessage());
        }
    }

    public function confirmOverwrite(Request $request)
    {
        $data['newAnimal'] = PetAdapter::fromApi($request->all()['newAnimal']);
        $data['oldAnimal']  = $this->petService->getPet($data['newAnimal']->getId());

        $data['newAnimal']->categoryName = PetCategoryEnum::fromId($data['newAnimal']->getCategoryId())->getName();
        $data['oldAnimal']->categoryName = PetCategoryEnum::fromId($data['oldAnimal']->getCategoryId())->getName();

        if (! $data['oldAnimal'] || !$data['newAnimal']) {

            return redirect()->route('home')->with('error', 'Brak danych do nadpisania.');
        }
        try {

            return view('pets.confirm-overwrite', [
                'oldAnimal' => $data['oldAnimal'],
                'newAnimal' => $data['newAnimal'],
            ]);
        } catch (\Exception $e) {

            return redirect()->route('home')->with('error', $e->getMessage());
        }
    }
}
