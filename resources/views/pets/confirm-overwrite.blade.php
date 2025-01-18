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
                                <input type="text" class="form-control" value="{{ $oldAnimal->getId() }}" readonly>
                                <input type="text" name="id" class="form-control" value="{{ $newAnimal->getId() }}"
                                    readonly>
                            </div>

                            <!-- Imię zwierzaka -->
                            <div class="input-group mb-3">
                                <span class="input-group-text"><strong>Imię:</strong></span>
                                <input type="text" class="form-control" value="{{ $oldAnimal->getName() }}" readonly>
                                <input type="text" name="name" class="form-control"
                                    value="{{ $newAnimal->getName() }}" readonly>
                            </div>

                            <!-- Kategoria zwierzaka -->
                            <div class="input-group mb-3">
                                <span class="input-group-text"><strong>Kategoria:</strong></span>
                                <input type="text" class="form-control" value="{{ $oldAnimal->categoryName }}" readonly>
                                <input type="text" class="form-control" value="{{ $newAnimal->categoryName }}" readonly>
                                <input type="hidden" name="category" class="form-control"
                                    value="{{ $newAnimal->getCategoryId() }}" readonly>
                            </div>

                            <!-- Status zwierzaka -->
                            <div class="input-group mb-3">
                                <span class="input-group-text"><strong>Status:</strong></span>
                                <input type="text" class="form-control" value="{{ $oldAnimal->getStatus() }}" readonly>
                                <input type="text" name="status" class="form-control"
                                    value="{{ $newAnimal->getStatus() }}" readonly>
                            </div>

                            <!-- Linki do zdjęć -->
                            <div class="input-group mb-3">
                                <span class="input-group-text"><strong>Zdjęcia:</strong></span>
                                <div class="form-control">
                                    @foreach ($oldAnimal->getPhotoUrls() as $photo)
                                        <input value="{{ $photo }}"><br>
                                    @endforeach
                                </div>
                                <div class="form-control">
                                    @foreach ($newAnimal->getPhotoUrls() as $photo)
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
                                <a href="{{ route('pets.create', ['data' => json_encode(\App\Services\PetAdapter::toArray($newAnimal))]) }}"
                                    class="btn btn-warning">Edytuj
                                    dodawanie</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
