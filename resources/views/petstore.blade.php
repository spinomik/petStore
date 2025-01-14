@extends('app')

@section('content')
    <div class="container text-center">
        <h1>Witaj w PetStore!</h1>
        <button class="btn btn-primary my-3" onclick="window.location.href='{{ route('pets.create') }}'">Dodaj
            zwierzaka</button>

        <button class="btn btn-secondary my-3" data-bs-toggle="modal" data-bs-target="#searchPetModal">
            Szukaj zwierzaka
        </button>
    </div>

    <div class="modal fade" id="searchPetModal" tabindex="-1" aria-labelledby="searchPetModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="searchPetModalLabel">Szukaj zwierzaka</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('pets.search') }}" method="GET">
                        <div class="mb-3">
                            <label for="petId" class="form-label">Podaj ID zwierzaka</label>
                            <input type="text" name="id" id="petId" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Szukaj</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
