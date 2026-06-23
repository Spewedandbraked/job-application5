# Task Management API

REST API для управления списком задач.

## Стек

- PHP 8.3, Laravel 13
- PostgreSQL 16
- Spatie Query Builder
- Swagger (l5-swagger)
- Docker

## Функционал

- CRUD задачи
- Поиск по названию, фильтрация по статусу и приоритету
- Сортировка по due_date, created_at, title, priority, status
- Пагинация
- Валидация
- Swagger-документация

## Деплой (Docker)

cd _sinenko
cp .env.example .env

Заполни _sinenko/.env:

COMPOSE_PROJECT_NAME=myapp
DB_DATABASE=app
DB_USERNAME=app
DB_PASSWORD=password
APP_PORT=80

docker compose up -d --build

Приложение: http://localhost:80
Swagger: http://localhost:80/api/documentation
