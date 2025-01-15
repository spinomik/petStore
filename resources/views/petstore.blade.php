@extends('app')

@section('content')
    <div class="container text-center">
        <h1 class="mb-4">Witaj w PetStore!</h1>
        <div class="row">
            <div class="col"> <button class="btn btn-success btn-custom my-3"
                    onclick="window.location.href='{{ route('pets.create') }}'">
                    Dodaj zwierzaka
                </button></div>
            <div class="col">
                <div class="btn-container d-flex justify-content-center align-items-center">
                    <div class="input-group mb-3" id="searchPetInputGroup">
                        <input type="number" class="form-control" id="petId" placeholder="Podaj ID zwierzaka"
                            aria-label="Pet ID" aria-describedby="button-addon2" required>
                        <button class="btn btn-outline-primary" type="button" id="button-addon2"
                            onclick="submitSearchForm()">Szukaj</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function submitSearchForm() {
            var petId = document.getElementById('petId').value;
            if (petId) {
                window.location.href = `{{ route('pets.search') }}?id=${petId}`;
            }
        }
    </script>
@endsection
