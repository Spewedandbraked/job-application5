@extends('layouts.app')

@section('content')
    <div>
        <x-form.form action="/api/tasks" method="POST" submit-text="Создать" :initial-data="json_encode([
            'title' => '',
            'description' => '',
            'due_date' => '',
            'category' => '',
            'priority' => 'medium',
            'status' => 'pending',
        ])">
            <x-form.input label="Название" name="title" required maxlength="255" />
            <x-form.input label="Описание" name="description" type="textarea" rows="3" />
            <x-form.input label="Срок выполнения" name="due_date" type="datetime-local" required />
            <x-form.input label="Категория" name="category" required maxlength="100" />
            <x-form.select label="Приоритет" name="priority" :options="['low' => 'Низкий', 'medium' => 'Средний', 'high' => 'Высокий']" />
            <x-form.select label="Статус" name="status" :options="['pending' => 'Не выполнена', 'completed' => 'Выполнена']" />
        </x-form.form>
    </div>
@endsection
