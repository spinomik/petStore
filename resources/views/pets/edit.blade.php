@extends('app')

@section('content')
    <div class="container">
        <h2 class="mb-4">Edytuj Zwierzaka</h2>

        <form method="POST" action="{{ route('pets.update', $pet['id']) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="category" class="form-label">Kategoria</label>
                <select name="category" id="category" class="form-select" required>
                    @foreach ($categories as $key => $value)
                        <option value="{{ $key }}" {{ $pet['category']['id'] == $key ? 'selected' : '' }}>
                            {{ $value }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="name" class="form-label">Nazwa</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $pet['name'] }}"
                    required>
            </div>

            <div class="mb-3">
                <label for="photoUrls" class="form-label">Linki zdjęć</label>
                <div id="photoUrlsContainer">
                    @foreach ($pet['photoUrls'] as $photoUrl)
                        <div class="input-group mb-3">
                            <input type="text" name="photoUrls[]" class="form-control" value="{{ $photoUrl }}"
                                required>
                            <button class="btn btn-outline-secondary" type="button" onclick="addPhotoUrlField()">+</button>
                            <button class="btn btn-outline-danger" type="button" onclick="removePhotoUrlField(this)"
                                style="display:inline;">-</button>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select name="status" id="status" class="form-select" required>
                    @foreach ($statuses as $status)
                        <option value="{{ $status }}" {{ $pet['status'] == $status ? 'selected' : '' }}>
                            {{ ucfirst($status) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-success">Zapisz</button>
            <a href="{{ route('home') }}" class="btn btn-secondary">Anuluj</a>
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

        function removePhotoUrlField(button) {
            button.closest('.input-group').remove();
        }
    </script>
@endsection
