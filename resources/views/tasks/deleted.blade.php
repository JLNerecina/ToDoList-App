@extends('app')

@section('title', 'Deleted Tasks')

@section('extra-css')
<style>
    .page-header {
        margin-bottom: 30px;
    }

    .page-title {
        color: white;
        font-size: 32px;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .page-subtitle {
        color: rgba(255, 255, 255, 0.7);
        font-size: 14px;
    }

    .trash-info {
        background: rgba(255, 255, 255, 0.08);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.15);
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .trash-info-text {
        color: rgba(255, 255, 255, 0.8);
        font-size: 14px;
    }

    .tasks-table {
        width: 100%;
        border-collapse: collapse;
    }

    .tasks-table thead {
        border-bottom: 2px solid rgba(255, 255, 255, 0.2);
    }

    .tasks-table th {
        padding: 15px;
        text-align: left;
        color: rgba(255, 255, 255, 0.8);
        font-weight: 600;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .tasks-table tbody tr {
        background: rgba(255, 255, 255, 0.05);
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        transition: all 0.3s ease;
    }

    .tasks-table tbody tr:hover {
        background: rgba(255, 255, 255, 0.1);
    }

    .tasks-table td {
        padding: 15px;
        color: white;
        font-size: 14px;
    }

    .task-title {
        font-weight: 600;
    }

    .task-actions {
        display: flex;
        gap: 8px;
    }

    .no-tasks {
        text-align: center;
        padding: 60px 20px;
        color: rgba(255, 255, 255, 0.5);
    }

    .btn-restore {
        background: linear-gradient(135deg, #34d399 0%, #10b981 100%);
        color: white;
        padding: 8px 16px;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        font-size: 12px;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
        text-align: center;
    }

    .btn-restore:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);
    }

    @media (max-width: 768px) {
        .trash-info {
            flex-direction: column;
            gap: 15px;
        }

        .tasks-table {
            font-size: 12px;
        }

        .tasks-table th,
        .tasks-table td {
            padding: 10px 8px;
        }

        .btn-sm {
            padding: 6px 12px;
            font-size: 11px;
        }
    }
</style>
@endsection

@section('content')
<div class="page-header">
    <h1 class="page-title">Trash</h1>
    <p class="page-subtitle">View and restore your deleted tasks</p>
</div>

<!-- Trash Info -->
@if($tasks->count() > 0)
    <div class="trash-info">
        <span class="trash-info-text">
            You have {{ $tasks->count() }} deleted task{{ $tasks->count() !== 1 ? 's' : '' }} in trash
        </span>
        <span class="trash-info-text" style="color: rgba(255, 255, 255, 0.6); font-size: 12px;">
            Deleted tasks are permanently removed after 30 days
        </span>
    </div>
@endif

<!-- Deleted Tasks Table -->
@if($tasks->count() > 0)
    <div class="glass-card">
        <table class="tasks-table">
            <thead>
                <tr>
                    <th style="width: 5%;">No.</th>
                    <th>Task Name</th>
                    <th>Category</th>
                    <th>Priority</th>
                    <th>Deadline</th>
                    <th>Status</th>
                    <th>Deleted On</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tasks as $index => $task)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td class="task-title">{{ Str::limit($task->title, 40) }}</td>
                        <td>
                            <span class="glass" style="padding: 5px 12px; border-radius: 8px; font-size: 12px;">
                                {{ $task->category->name }}
                            </span>
                        </td>
                        <td>
                            <span class="priority-badge priority-{{ strtolower($task->priority) }}">
                                {{ $task->priority }}
                            </span>
                        </td>
                        <td>
                            @if ($task->deadline)
                                <span class="glass" style="padding: 5px 12px; border-radius: 8px; font-size: 12px;">
                                    {{ $task->deadline->format('M d, Y') }}
                                </span>
                            @else
                                <span style="color: rgba(255, 255, 255, 0.5);">-</span>
                            @endif
                        </td>
                        <td>
                            <span class="status-badge status-deleted">
                                {{ $task->status }}
                            </span>
                        </td>
                        <td>
                            {{ $task->deleted_at->format('M d, Y H:i') }}
                        </td>
                        <td>
                            <div class="task-actions">
                                <form action="{{ route('tasks.restore', $task->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn-restore">Restore</button>
                                </form>
                                <form action="{{ route('tasks.forceDelete', $task->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Permanently delete this task? This cannot be undone.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete Forever</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@else
    <div class="glass-card" style="text-align: center; padding: 60px 20px;">
        <h3 style="color: white; margin-bottom: 10px;">Trash is empty</h3>
        <p style="color: rgba(255, 255, 255, 0.6);">
            Your deleted tasks will appear here. You can restore them at any time.
        </p>
        <a href="{{ route('tasks.index') }}" class="btn btn-primary" style="margin-top: 20px;">Go back to tasks</a>
    </div>
@endif
@endsection