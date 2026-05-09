@extends('app')

@section('title', 'Tasks - To-Do List')

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

    .header-section {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        flex-wrap: wrap;
        gap: 20px;
    }

    .search-container {
        width: 300px;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 15px;
        margin-bottom: 30px;
    }

    .stat-link {
        text-decoration: none;
        color: inherit;
        display: block;
    }

    .stat-card {
        background: rgba(255, 255, 255, 0.08);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.15);
        border-radius: 12px;
        padding: 20px;
        text-align: center;
        transition: transform 0.2s ease, background 0.2s ease, border-color 0.2s ease;
        cursor: pointer;
        height: 100%;
    }

    .stat-card:hover {
        transform: translateY(-3px);
        background: rgba(255, 255, 255, 0.12);
    }

    .stat-card.active {
        border-color: #6390B8;
        background: rgba(99, 144, 184, 0.2);
        box-shadow: 0 4px 15px rgba(99, 144, 184, 0.2);
    }

    .stat-number {
        font-size: 28px;
        font-weight: 700;
        color: #83AACC;
        margin-bottom: 5px;
    }

    .stat-label {
        color: rgba(255, 255, 255, 0.7);
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .filters-section {
        background: rgba(255, 255, 255, 0.08);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.15);
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 30px;
    }

    .filters-title {
        color: white;
        font-weight: 600;
        margin-bottom: 15px;
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .filters-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .filter-label {
        color: rgba(255, 255, 255, 0.8);
        font-size: 12px;
        font-weight: 500;
    }

    .filter-select {
        width: 100%;
        padding: 10px 12px;
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 8px;
        color: white;
        font-size: 13px;
    }

    .filter-select option {
        background-color: #26547C;
        color: white;
    }

    .tasks-section {
        margin-bottom: 40px;
    }

    .section-title {
        color: white;
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid rgba(255, 255, 255, 0.15);
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

    @media (max-width: 768px) {
        .header-section {
            flex-direction: column;
            align-items: stretch;
        }

        .search-container {
            width: 100%;
        }

        .filters-grid {
            grid-template-columns: 1fr;
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
<!-- Header Section -->
<div class="header-section">
    <div>
        <h1 class="page-title">Task Dashboard</h1>
        <p class="page-subtitle">Organize and track your tasks efficiently</p>
    </div>
    
    <!-- Search Bar -->
    <div class="search-container">
        <form action="{{ route('tasks.index') }}" method="GET" style="display: flex; gap: 8px;">
            <input type="text" name="search" class="form-control" placeholder="Search tasks..." value="{{ request('search') }}" style="background: rgba(255,255,255,0.1); color: white; border-radius: 8px; flex: 1;">
            <button type="submit" class="btn btn-primary btn-sm">Search</button>
            @if(request('search') || request('priority') || request('category') || request('deadline_filter'))
                <a href="{{ route('tasks.index') }}" class="btn btn-danger btn-sm">Clear</a>
            @endif
        </form>
    </div>
</div>

<!-- Statistics Grid -->
<div class="stats-grid">
    <a href="{{ route('tasks.index') }}" class="stat-link">
        <div class="stat-card {{ (!isset($currentStatus) || $currentStatus === 'All') ? 'active' : '' }}">
            <div class="stat-number">{{ $allTasks->count() }}</div>
            <div class="stat-label">Total Tasks</div>
        </div>
    </a>
    <a href="{{ route('tasks.byStatus', 'To Do') }}" class="stat-link">
        <div class="stat-card {{ (isset($currentStatus) && $currentStatus === 'To Do') ? 'active' : '' }}">
            <div class="stat-number">{{ $allTasks->where('status', 'To Do')->count() }}</div>
            <div class="stat-label">To Do</div>
        </div>
    </a>
    <a href="{{ route('tasks.byStatus', 'In Progress') }}" class="stat-link">
        <div class="stat-card {{ (isset($currentStatus) && $currentStatus === 'In Progress') ? 'active' : '' }}">
            <div class="stat-number">{{ $allTasks->where('status', 'In Progress')->count() }}</div>
            <div class="stat-label">In Progress</div>
        </div>
    </a>
    <a href="{{ route('tasks.byStatus', 'Completed') }}" class="stat-link">
        <div class="stat-card {{ (isset($currentStatus) && $currentStatus === 'Completed') ? 'active' : '' }}">
            <div class="stat-number">{{ $allTasks->where('status', 'Completed')->count() }}</div>
            <div class="stat-label">Completed</div>
        </div>
    </a>
    <a href="{{ route('tasks.byStatus', 'Submitted') }}" class="stat-link">
        <div class="stat-card {{ (isset($currentStatus) && $currentStatus === 'Submitted') ? 'active' : '' }}">
            <div class="stat-number">{{ $allTasks->where('status', 'Submitted')->count() }}</div>
            <div class="stat-label">Submitted</div>
        </div>
    </a>
</div>

<!-- Advanced Filters -->
<div class="filters-section">
    <div class="filters-title">Advanced Filters</div>
    <form action="{{ route('tasks.index') }}" method="GET" style="margin-bottom: 0;">
        <input type="hidden" name="search" value="{{ request('search') }}">
        <div class="filters-grid">
            <div class="filter-group">
                <label class="filter-label">Priority</label>
                <select name="priority" class="filter-select" onchange="this.form.submit()">
                    <option value="All" {{ request('priority') === 'All' || !request('priority') ? 'selected' : '' }}>All Priorities</option>
                    <option value="High" {{ request('priority') === 'High' ? 'selected' : '' }}>High</option>
                    <option value="Medium" {{ request('priority') === 'Medium' ? 'selected' : '' }}>Medium</option>
                    <option value="Low" {{ request('priority') === 'Low' ? 'selected' : '' }}>Low</option>
                </select>
            </div>

            <div class="filter-group">
                <label class="filter-label">Category</label>
                <select name="category" class="filter-select" onchange="this.form.submit()">
                    <option value="All" {{ request('category') === 'All' || !request('category') ? 'selected' : '' }}>All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="filter-group">
                <label class="filter-label">Deadline</label>
                <select name="deadline_filter" class="filter-select" onchange="this.form.submit()">
                    <option value="" {{ !request('deadline_filter') ? 'selected' : '' }}>All Deadlines</option>
                    <option value="overdue" {{ request('deadline_filter') === 'overdue' ? 'selected' : '' }}>Overdue</option>
                    <option value="today" {{ request('deadline_filter') === 'today' ? 'selected' : '' }}>Today</option>
                    <option value="upcoming" {{ request('deadline_filter') === 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                </select>
            </div>
        </div>
    </form>
</div>

<!-- Overdue Tasks -->
@if ($overdueTasks->count() > 0)
    <div class="tasks-section">
        <div class="section-title">Overdue Tasks ({{ $overdueTasks->count() }})</div>
        <table class="tasks-table">
            <thead>
                <tr>
                    <th>Task Name</th>
                    <th>Category</th>
                    <th>Priority</th>
                    <th>Deadline</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($overdueTasks->sortBy('deadline') as $task)
                    <tr>
                        <td class="task-title">{{ $task->title }}</td>
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
                        <td>{{ $task->deadline->format('M d, Y') }}</td>
                        <td>
                            <span class="status-badge status-{{ strtolower(str_replace(' ', '', $task->status)) }}">
                                {{ $task->status }}
                            </span>
                        </td>
                        <td>
                            <div class="task-actions">
                                <a href="{{ route('tasks.edit', $task) }}" class="btn btn-primary btn-sm">Edit</a>
                                <form action="{{ route('tasks.destroy', $task) }}" method="POST" style="display: inline;" onsubmit="return confirm('Move to trash?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif

<!-- Today's Tasks -->
@if ($todayTasks->count() > 0)
    <div class="tasks-section">
        <div class="section-title">Today's Tasks ({{ $todayTasks->count() }})</div>
        <table class="tasks-table">
            <thead>
                <tr>
                    <th>Task Name</th>
                    <th>Category</th>
                    <th>Priority</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($todayTasks as $task)
                    <tr>
                        <td class="task-title">{{ $task->title }}</td>
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
                            <select class="form-control" style="width: 150px; padding: 8px; font-size: 12px;" onchange="updateTaskStatus({{ $task->id }}, this.value)">
                                <option value="To Do" {{ $task->status === 'To Do' ? 'selected' : '' }}>To Do</option>
                                <option value="In Progress" {{ $task->status === 'In Progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="Completed" {{ $task->status === 'Completed' ? 'selected' : '' }}>Completed</option>
                                <option value="Submitted" {{ $task->status === 'Submitted' ? 'selected' : '' }}>Submitted</option>
                            </select>
                        </td>
                        <td>
                            <div class="task-actions">
                                <a href="{{ route('tasks.edit', $task) }}" class="btn btn-primary btn-sm">Edit</a>
                                <form action="{{ route('tasks.destroy', $task) }}" method="POST" style="display: inline;" onsubmit="return confirm('Move to trash?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif

<!-- Upcoming Tasks -->
@if ($upcomingTasks->count() > 0)
    <div class="tasks-section">
        <div class="section-title">Upcoming Tasks ({{ $upcomingTasks->count() }})</div>
        <table class="tasks-table">
            <thead>
                <tr>
                    <th>Task Name</th>
                    <th>Category</th>
                    <th>Priority</th>
                    <th>Deadline</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($upcomingTasks->sortBy('deadline')->take(10) as $task)
                    <tr>
                        <td class="task-title">{{ $task->title }}</td>
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
                        <td>{{ $task->deadline->format('M d, Y') }}</td>
                        <td>
                            <span class="status-badge status-{{ strtolower(str_replace(' ', '', $task->status)) }}">
                                {{ $task->status }}
                            </span>
                        </td>
                        <td>
                            <div class="task-actions">
                                <a href="{{ route('tasks.edit', $task) }}" class="btn btn-primary btn-sm">Edit</a>
                                <form action="{{ route('tasks.destroy', $task) }}" method="POST" style="display: inline;" onsubmit="return confirm('Move to trash?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif

<!-- Main / Filtered Tasks List -->
@if (isset($tasks) && $tasks->count() > 0)
    <div class="tasks-section">
        <div class="section-title">
            {{ isset($currentStatus) && $currentStatus !== 'All' ? $currentStatus : 'All' }} Tasks ({{ $tasks->count() }})
        </div>
        <table class="tasks-table">
            <thead>
                <tr>
                    <th style="width: 5%;">No.</th>
                    <th>Task Name</th>
                    <th>Category</th>
                    <th>Priority</th>
                    <th>Deadline</th>
                    <th>Status</th>
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
                            <span class="status-badge status-{{ strtolower(str_replace(' ', '', $task->status)) }}">
                                {{ $task->status }}
                            </span>
                        </td>
                        <td>
                            <div class="task-actions">
                                <a href="{{ route('tasks.edit', $task) }}" class="btn btn-primary btn-sm">Edit</a>
                                <form action="{{ route('tasks.destroy', $task) }}" method="POST" style="display: inline;" onsubmit="return confirm('Move to trash?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
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
        <h3 style="color: white; margin-bottom: 10px;">No tasks found</h3>
        <p style="color: rgba(255, 255, 255, 0.6);">
            {{ isset($currentStatus) && $currentStatus !== 'All' ? 'Try checking another status filter.' : 'Create your first task to get started!' }}
        </p>
        @if(!isset($currentStatus) || $currentStatus === 'All')
            <a href="{{ route('tasks.create') }}" class="btn btn-primary" style="margin-top: 20px;">Create First Task</a>
        @endif
    </div>
@endif
@endsection

@section('extra-js')
<script>
function updateTaskStatus(taskId, status) {
    fetch(`/tasks/${taskId}/status`, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ status: status })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    })
    .catch(error => console.error('Error:', error));
}
</script>
@endsection