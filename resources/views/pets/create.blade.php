@extends('app')

@section('content')
    <div class="container">
        <h1>Dodaj nowego zwierzaka</h1>
        <form action="{{ route('pets.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="id" class="form-label">ID</label>
                <input type="number" name="id" id="id" class="form-control"
                    value="{{ old('id', $data['id'] ?? '') }}" required>
            </div>
            <div class="mb-3">
                <label for="category" class="form-label">Kategoria</label>
                <select name="category" id="category" class="form-select">
                    @foreach ($categories as $key => $category)
                        <option value="{{ $key }}"
                            {{ old('category', $data['category']['id'] ?? '') == $key ? 'selected' : '' }}>
                            {{ $category }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Nazwa</label>
                <input type="text" name="name" id="name" class="form-control"
                    value="{{ old('name', $data['name'] ?? '') }}" required>
            </div>
            <div class="mb-3">
                <label for="photoUrls" class="form-label">Linki zdjęć </label>
                <div id="photoUrlsContainer">
                    @if (isset($data['photoUrls']))
                        @foreach ($data['photoUrls'] as $photoUrl)
                            <div class="input-group mb-3">
                                <input type="text" name="photoUrls[]" class="form-control" value="{{ $photoUrl }}"
                                    required>
                                <button class="btn btn-outline-secondary" type="button"
                                    onclick="addPhotoUrlField()">+</button>
                                <button class="btn btn-outline-danger" type="button" onclick="removePhotoUrlField()"
                                    style="display:none;">-</button>
                            </div>
                        @endforeach
                    @else
                        <div class="input-group mb-3">
                            <input type="text" name="photoUrls[]" id="photoUrls" class="form-control" required>
                            <button class="btn btn-outline-secondary" type="button" onclick="addPhotoUrlField()">+</button>
                            <button class="btn btn-outline-danger" type="button" onclick="removePhotoUrlField()"
                                style="display:none;">-</button>
                        </div>
                    @endif
                </div>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select name="status" id="status" class="form-select">
                    @foreach ($statuses as $status)
                        <option value="{{ $status }}"
                            {{ old('status', $data['status'] ?? '') == $status ? 'selected' : '' }}>
                            {{ $status }}</option>
                    @endforeach
                </select>
            </div>
            <a href="{{ route('home') }}" class="btn btn-secondary my-3">Powrót</a>
            <button type="submit" class="btn btn-primary">Dodaj</button>
        </form>
    </div>

    <script>
        function addPhotoUrlField() {
            const container = document.getElementById('photoUrlsContainer');
            const newField = document.createElement('div');
            newField.classList.add('input-group', 'mb-3');

            const input = document.createElement('input');
            input.type = 'text';
            input.name = 'photoUrls[]';
            input.classList.add('form-control');
            input.required = true;

            const addButton = document.createElement('button');
            addButton.type = 'button';
            addButton.classList.add('btn', 'btn-outline-secondary');
            addButton.innerHTML = '+';
            addButton.onclick = addPhotoUrlField;

            const removeButton = document.createElement('button');
            removeButton.type = 'button';
            removeButton.classList.add('btn', 'btn-outline-danger');
            removeButton.innerHTML = '-';
            removeButton.style.display = 'inline';
            removeButton.onclick = () => {
                newField.remove();
            };

            newField.appendChild(input);
            newField.appendChild(addButton);
            newField.appendChild(removeButton);
            container.appendChild(newField);
        }

        function removePhotoUrlField() {
            const container = document.getElementById('photoUrlsContainer');
            const fields = container.querySelectorAll('.input-group');

            if (fields.length > 1) {
                fields[fields.length - 1].remove();
            }
        }
    </script>
@endsection
