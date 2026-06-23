@extends('layouts.app')

@section('content')
<div x-data="taskManager()" x-init="fetchTasks()">
    {{-- Фильтры --}}
    <div class="filters-bar">
        <div class="filter-group">
            <label class="form-label">Поиск</label>
            <input type="text" class="form-input" x-model="filters.search"
                   @input.debounce.300="fetchTasks()">
        </div>
        <div class="filter-group">
            <label class="form-label">Статус</label>
            <select class="form-select" x-model="filters.status" @change="fetchTasks()">
                <option value="">Все</option>
                <option value="pending">Pending</option>
                <option value="completed">Completed</option>
            </select>
        </div>
        <div class="filter-group">
            <label class="form-label">Приоритет</label>
            <select class="form-select" x-model="filters.priority" @change="fetchTasks()">
                <option value="">Все</option>
                <option value="low">Low</option>
                <option value="medium">Medium</option>
                <option value="high">High</option>
            </select>
        </div>
        <div class="filter-group">
            <label class="form-label">Сортировка</label>
            <select class="form-select" x-model="sort" @change="fetchTasks()">
                <option value="due_date">Дата (возр.)</option>
                <option value="-due_date">Дата (убыв.)</option>
                <option value="created_at">Создание (возр.)</option>
                <option value="-created_at">Создание (убыв.)</option>
            </select>
        </div>
    </div>

    {{-- Таблица задач --}}
    <div class="task-table">
        <div class="task-table-header">
            <div class="col">Название</div>
            <div class="col">Статус</div>
            <div class="col">Приоритет</div>
            <div class="col">Срок</div>
            <div class="col-actions"></div>
        </div>

        <template x-for="task in tasks" :key="task.id">
            <div class="task-row">
                <div class="col">
                    <strong x-text="task.title"></strong>
                    <small x-show="task.description"
                           x-text="task.description.substring(0, 60) + (task.description.length > 60 ? '...' : '')"></small>
                </div>
                <div class="col">
                    <span class="badge" :class="'badge-' + task.status" x-text="task.status"></span>
                </div>
                <div class="col">
                    <span class="badge" :class="'badge-' + task.priority" x-text="task.priority"></span>
                </div>
                <div class="col" x-text="formatDate(task.due_date)"></div>
                <div class="col-actions">
                    <a :href="'/tasks/' + task.id + '/edit'" class="btn btn-sm btn-secondary">✏️</a>
                    <button class="btn btn-sm btn-danger" @click="deleteTask(task.id)">🗑️</button>
                </div>
            </div>
        </template>
    </div>

    {{-- Пагинация --}}
    <div class="pagination" x-show="totalPages > 1">
        <button class="page-item" @click="changePage(currentPage - 1)"
                :disabled="currentPage <= 1">←</button>
        <template x-for="page in pagesArray" :key="page">
            <button class="page-item" :class="{ active: page === currentPage }"
                    @click="changePage(page)" x-text="page"></button>
        </template>
        <button class="page-item" @click="changePage(currentPage + 1)"
                :disabled="currentPage >= totalPages">→</button>
    </div>
</div>
@endsection

@push('scripts')
<script>
function taskManager() {
    return {
        tasks: [],
        filters: { search: '', status: '', priority: '' },
        sort: 'due_date',
        currentPage: 1,
        totalPages: 1,
        perPage: 15,

        async fetchTasks() {
            const params = new URLSearchParams({
                'filter[search]': this.filters.search,
                'filter[status]': this.filters.status,
                'filter[priority]': this.filters.priority,
                sort: this.sort,
                page: this.currentPage,
                per_page: this.perPage
            });
            try {
                const response = await fetch(`/api/tasks?${params}`);
                if (!response.ok) throw new Error('Ошибка сети');
                const data = await response.json();
                this.tasks = data.data;
                this.currentPage = data.current_page;
                this.totalPages = data.last_page;
            } catch (error) {
                console.error('Ошибка загрузки задач', error);
            }
        },

        async deleteTask(id) {
            if (!confirm('Удалить задачу?')) return;
            try {
                await fetch(`/api/tasks/${id}`, { method: 'DELETE' });
                this.fetchTasks(); // обновить список
            } catch (error) {
                console.error('Ошибка удаления задачи', error);
            }
        },

        changePage(page) {
            if (page < 1 || page > this.totalPages) return;
            this.currentPage = page;
            this.fetchTasks();
        },

        formatDate(dateString) {
            return new Date(dateString).toLocaleString('ru-RU');
        },

        get pagesArray() {
            return Array.from({ length: this.totalPages }, (_, i) => i + 1);
        }
    };
}
</script>
@endpush
