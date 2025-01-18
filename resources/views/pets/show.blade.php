@extends('app')

@section('content')
    <div class="container">
        <h1 class="text-center">Szczegóły</h1>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <!-- Dane zwierzaka -->
                    <div class="col-md-6">
                        <div class="input-group mb-3">
                            <span class="input-group-text"><strong>Id:</strong></span>
                            <input type="text" class="form-control" value="{{ $pet->getId() }}" readonly>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text"><strong>imię:</strong></span>
                            <input type="text" class="form-control" value="{{ $pet->getName() }}" readonly>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text"><strong>Kategoria:</strong></span>
                            <input type="text" class="form-control" value="{{ $pet->categoryName }}" readonly>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text"><strong>Status:</strong></span>
                            <input type="text" class="form-control" value="{{ $pet->getStatus() }}" readonly>
                        </div>
                    </div>

                    <!-- Karuzela ze zdjęciami -->
                    <div class="col-md-6">
                        <div id="petPhotoCarousel" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                @foreach ($pet->getPhotoUrls() as $index => $photo)
                                    <div class="carousel-item @if ($index === 0) active @endif">
                                        <img src="{{ $photo }}" class="d-block w-100"
                                            alt="Photo of {{ $pet->getName() }}" style="height: 300px; object-fit: cover;">
                                    </div>
                                @endforeach
                            </div>
                            <!-- Przyciski nawigacji karuzeli -->
                            <button class="carousel-control-prev" type="button" data-bs-target="#petPhotoCarousel"
                                data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#petPhotoCarousel"
                                data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Przyciski do nawigacji -->
        <div class="d-flex justify-content-between mt-3">
            <a href="{{ route('home') }}" class="btn btn-secondary">Powrót</a>
            <div>
                <a href="{{ route('pets.edit', $pet->getId()) }}" class="btn btn-warning">Edytuj</a>
                <form action="{{ route('pets.destroy', $pet->getId()) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Usuń</button>
                </form>
            </div>
            <button class="btn btn-primary" onclick="location.href='{{ route('home') }}'">Szukaj innego</button>
        </div>
    </div>
@endsection
