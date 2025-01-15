# PetStore Aplikacja

PetStore to aplikacja webowa do zarządzania zwierzętami, która umożliwia dodawanie, edytowanie oraz przeglądanie informacji o zwierzętach w sklepie. Aplikacja jest oparta na Laravelu oraz wykorzystuje Docker do uruchomienia aplikacji w środowisku kontenerowym.

## Wymagania

-   **PHP** - Aplikacja jest zbudowana przy użyciu PHP 8.4.2
-   **Laravel** - Aplikacja jest zbudowana przy użyciu Laravel 11.31
-   **Git** - do klonowania repozytorium
-   **Docker** - do uruchomienia aplikacji w kontenerach

## Instrukcja instalacji

### 1. Klonowanie repozytorium

Klonuj repozytorium aplikacji na swoje lokalne środowisko:

```bash
    git clone https://github.com/spinomik/petStore.git
```

### 2. Wejdź do katalogu projektu

```bash
    cd petStore
```

### 3. Skonfiguruj plik .env

```bash
    cp .env.example .env
```

Ustaw klucze środowiskowe:

• API_KEY – klucz API do zewnętrznego API  
• APP_KEY – klucz aplikacji (możesz go wygenerować przy pomocy komendy php artisan key:generate w środowisku lokalnym)

### 4. Uruchamianie aplikacji z Docker

```bash
    docker-compose up --build
```

### 5. Uruchamianie aplikacji z Docker

Aplikacja powinna być teraz dostępna pod adresem: http://localhost:8080
