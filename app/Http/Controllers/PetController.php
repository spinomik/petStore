<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PetService;
use App\Enums\PetCategoryEnum;
use App\Enums\PetStatusEnum;

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
        $validated = $request->validate([
            'id' => 'required|integer',
            'category' => 'required|integer',
            'name' => 'required|string',
            'photoUrls' => 'required|array',
            'status' => 'required|string',
            'overwrite' => 'nullable|boolean',
        ]);

        $data = [
            'id' => $validated['id'],
            'category' => [
                'id' => $validated['category'],
                'name' => PetCategoryEnum::getAll()[$validated['category']],
            ],
            'name' => $validated['name'],
            'photoUrls' => $validated['photoUrls'],
            'status' => $validated['status'],
        ];
        $petExists = $this->petService->existsPet($validated['id']);
        if ($petExists && !$request->boolean('overwrite')) {
            return redirect()
                ->route('pets.confirmOverwrite', [
                    'id' => $validated['id'],
                    'newAnimal' => $data,
                    'oldAnimal' => $this->petService->getPet($validated['id']),
                ])
                ->with('warning', 'Zwierzak o podanym ID już istnieje. Czy chcesz go nadpisać?');
        }

        try {
            $this->petService->createPet($data);
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

            if (empty($pet['photoUrls'])) {
                $pet['photoUrls'] = ['https://img.freepik.com/free-vector/hand-drawn-no-photo-sign_23-2149278213.jpg?t=st=1736882123~exp=1736885723~hmac=d87a6d612f1c5dda46813ae04bc01a3f18bd562140e6b5cf7a4c9b792ff9dc85&w=740'];
            }
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

        if (empty($pet['photoUrls'])) {
            $pet['photoUrls'] = [''];
        }
        return view('pets.edit', [
            'pet' => $pet,
            'categories' => PetCategoryEnum::getAll(),
            'statuses' => PetStatusEnum::getAll()
        ]);
    }

    public function update(Request $request, int $id)
    {
        $validated = $request->validate([
            'category' => 'required|integer',
            'name' => 'required|string|max:255',
            'photoUrls' => 'required|array',
            'status' => 'required|string',
        ]);

        $data = [
            'id' => $id,
            'category' => [
                'id' => (int)$validated['category'],
                'name' => PetCategoryEnum::getAll()[$validated['category']],
            ],
            'name' => $validated['name'],
            'photoUrls' => array_values($validated['photoUrls']),
            'status' => $validated['status'],
        ];

        try {
            $this->petService->updatePet($id, $data);

            return redirect()->route('home')->with('success', 'Zwierz zaktualizowany!');
        } catch (\Exception $e) {

            return redirect()->route('home')->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
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

        $data = $request->all();
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
