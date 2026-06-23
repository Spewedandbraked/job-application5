<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Управление задачами</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <header class="app-header">
        <h1>📋 Список задач</h1>
        <nav>
            <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Главная</a>
            <a href="{{ route('tasks.create') }}" class="btn btn-primary">+ Новая задача</a>
        </nav>
    </header>

    <main class="container">
        @yield('content')
    </main>

    <footer class="app-footer">
        <p>Task Management API ™ от Данечки</p>
    </footer>

    @stack('scripts')
</body>
</html>
