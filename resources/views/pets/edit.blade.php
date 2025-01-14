@extends('app')

@section('content')
    <div class="container">
        <h2 class="mb-4">Edytuj Zwierzaka</h2>

        <form method="POST" action="{{ route('pets.update', $pet['id']) }}">
            @csrf
            @method('PUT')

            <!-- Kategoria -->
            <div class="mb-3">
                <label for="category" class="form-label">Kategoria</label>
                <select name="category" id="category" class="form-select" required>
                    @foreach (\App\Enums\PetCategoryEnum::getAll() as $key => $value)
                        <option value="{{ $key }}" {{ $pet['category']['id'] == $key ? 'selected' : '' }}>
                            {{ $value }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Nazwa -->
            <div class="mb-3">
                <label for="name" class="form-label">Nazwa</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $pet['name'] }}"
                    required>
            </div>

            <!-- URL zdjęć -->
            <div class="mb-3">
                <label for="photoUrls" class="form-label">URL Zdjęć</label>
                <input type="text" class="form-control" id="photoUrls" name="photoUrls[]"
                    value="{{ implode(',', $pet['photoUrls']) }}" required>
            </div>

            <!-- Status -->
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select name="status" id="status" class="form-select" required>
                    @foreach (\App\Enums\PetStatusEnum::getAll() as $status)
                        <option value="{{ $status }}" {{ $pet['status'] == $status ? 'selected' : '' }}>
                            {{ ucfirst($status) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Przycisk Zapisz -->
            <button type="submit" class="btn btn-success">Zapisz</button>
            <a href="{{ route('home') }}" class="btn btn-secondary">Anuluj</a>
        </form>
    </div>
@endsection
