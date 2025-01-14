@extends('app')

@section('content')
    <div class="container">
        <h1>Szczegóły zwierzaka</h1>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ $pet['name'] }}</h5>
                <p>Kategoria: {{ $pet['category']['name'] }}</p>
                <p>Status: {{ $pet['status'] }}</p>
                <p>Zdjęcia:</p>
                @foreach ($pet['photoUrls'] as $photo)
                    <img src="{{ $photo }}" alt="Photo of {{ $pet['name'] }}" class="img-fluid mb-3">
                @endforeach
            </div>
        </div>
        <a href="{{ route('home') }}" class="btn btn-secondary my-3">Powrót</a>
        <a href="{{ route('pets.edit', $pet['id']) }}" class="btn btn-warning">Edytuj</a>
        <form action="{{ route('pets.destroy', $pet['id']) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Usuń</button>
        </form>
        <button class="btn btn-primary my-3" onclick="location.href='{{ route('home') }}'">Szukaj innego</button>
    </div>
@endsection
