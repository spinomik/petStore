@extends('app')

@section('content')
    <div class="container">
        <h1>Dodaj nowego zwierzaka</h1>
        <form action="{{ route('pets.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="id" class="form-label">ID</label>
                <input type="number" name="id" id="id" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="category" class="form-label">Kategoria</label>
                <select name="category" id="category" class="form-select">
                    @foreach ($categories as $key => $category)
                        <option value="{{ $key }}">{{ $category }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Nazwa</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="photoUrls" class="form-label">Linki zdjęć (oddziel przecinkami)</label>
                <input type="text" name="photoUrls[]" id="photoUrls" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select name="status" id="status" class="form-select">
                    @foreach ($statuses as $status)
                        <option value="{{ $status }}">{{ $status }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Dodaj</button>
        </form>
    </div>
@endsection
