@props(['task'])

<div class="task-row">
    <div class="col">
        <strong>{{ $task['title'] }}</strong>
        @if($task['description'])
            <br><small class="text-muted">{{ Str::limit($task['description'], 60) }}</small>
        @endif
    </div>
    <div class="col">
        <span class="badge badge-{{ $task['status'] }}">{{ $task['status'] }}</span>
    </div>
    <div class="col">
        <span class="badge badge-{{ $task['priority'] }}">{{ $task['priority'] }}</span>
    </div>
    <div class="col">{{ \Carbon\Carbon::parse($task['due_date'])->format('d.m.Y H:i') }}</div>
    <div class="col-actions">
        <a href="{{ route('tasks.edit', $task['id']) }}" class="btn btn-sm btn-secondary">✏️</a>
        <button class="btn btn-sm btn-danger" onclick="deleteTask({{ $task['id'] }})">🗑️</button>
    </div>
</div>
