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

    public function create()
    {
        return view(
            'pets.create',
            [
                'categories' => PetCategoryEnum::getAll(),
                'statuses' => PetStatusEnum::getAll()
            ]
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
        $response = $this->petService->createPet($data);
        return redirect()->route('home')->with('success', 'Zwierz dodany pomyślnie!');
    }

    public function search(Request $request)
    {
        $id = $request->input('id');
        $pet = $this->petService->getPet($id);
        if (empty($pet['photoUrls'])) {
            $pet['photoUrls'] = ['https://img.freepik.com/free-vector/hand-drawn-no-photo-sign_23-2149278213.jpg?t=st=1736882123~exp=1736885723~hmac=d87a6d612f1c5dda46813ae04bc01a3f18bd562140e6b5cf7a4c9b792ff9dc85&w=740'];
        }
        return view('pets.show', [
            'pet' => $pet
        ]);
    }

    public function edit(int $id)
    {
        $pet = $this->petService->getPet($id);
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

        $response = $this->petService->updatePet($id, $data);

        return redirect()->route('home')->with('success', 'Pet updated successfully!');
    }

    public function destroy($id)
    {
        $pet = $this->petService->getPet($id);
        if (isset($pet['type']) && $pet['type'] === 'error') {
            return redirect()->route('home')->with('error', 'Animal not found!');
        }
        $this->petService->deletePet($id);
        return redirect()->route('home')->with('success', 'Zwierz został usunięty!');
    }
}
