@extends('app')

@section('content')
    <div class="container">
        <h1 class="text-center">Potwierdź nadpisanie zwierzaka</h1>

        <form method="POST" action="{{ route('pets.store') }}">
            @csrf
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <!-- Dane zwierzaka -->
                        <div class="col-md-6">
                            <!-- Id zwierzaka -->
                            <div class="input-group mb-3">
                                <span class="input-group-text"><strong>Id:</strong></span>
                                <input type="text" class="form-control" value="{{ $oldAnimal['id'] }}" readonly>
                                <input type="text" name="id" class="form-control" value="{{ $newAnimal['id'] }}"
                                    readonly>
                            </div>

                            <!-- Imię zwierzaka -->
                            <div class="input-group mb-3">
                                <span class="input-group-text"><strong>Imię:</strong></span>
                                <input type="text" class="form-control" value="{{ $oldAnimal['name'] }}" readonly>
                                <input type="text" name="name" class="form-control" value="{{ $newAnimal['name'] }}"
                                    readonly>
                            </div>

                            <!-- Kategoria zwierzaka -->
                            <div class="input-group mb-3">
                                <span class="input-group-text"><strong>Kategoria:</strong></span>
                                <input type="text" class="form-control" value="{{ $oldAnimal['category']['name'] }}"
                                    readonly>
                                <input type="text" class="form-control" value="{{ $newAnimal['category']['name'] }}"
                                    readonly>
                                <input type="hidden" name="category" class="form-control"
                                    value="{{ $newAnimal['category']['id'] }}" readonly>
                            </div>

                            <!-- Status zwierzaka -->
                            <div class="input-group mb-3">
                                <span class="input-group-text"><strong>Status:</strong></span>
                                <input type="text" class="form-control" value="{{ $oldAnimal['status'] }}" readonly>
                                <input type="text" name="status" class="form-control" value="{{ $newAnimal['status'] }}"
                                    readonly>
                            </div>

                            <!-- Linki do zdjęć -->
                            <div class="input-group mb-3">
                                <span class="input-group-text"><strong>Zdjęcia:</strong></span>
                                <div class="form-control">
                                    @foreach ($oldAnimal['photoUrls'] as $photo)
                                        <input value="{{ $photo }}"><br>
                                    @endforeach
                                </div>
                                <div class="form-control">
                                    @foreach ($newAnimal['photoUrls'] as $photo)
                                        <input name="photoUrls[]" value="{{ $photo }}"><br>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Przycisk do potwierdzenia nadpisania -->
                        <div class="row mb-3">
                            <div class="col-sm-10 offset-sm-2">
                                <button type="submit" class="btn btn-success" name="overwrite" value="1">Potwierdź
                                    nadpisanie</button>
                                <!-- Przycisk do edytowania -->
                                <a href="{{ route('pets.create', ['data' => json_encode($newAnimal)]) }}"
                                    class="btn btn-warning">Edytuj dodawanie</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
