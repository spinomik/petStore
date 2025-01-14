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
        return view('pets.show', [
            'pet' => $pet
        ]);
    }

    public function edit(int $id)
    {
        $pet = $this->petService->getPet($id);

        return view('pets.edit', ['pet' => $pet]);
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
