@extends('app')

@section('title', 'Edit Task')

@section('extra-css')
<style>
    .form-container {
        max-width: 700px;
        margin: 40px auto;
    }

    .form-header {
        color: white;
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 30px;
    }

    .form-card {
        background: rgba(255, 255, 255, 0.08);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.15);
        border-radius: 15px;
        padding: 40px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 20px;
    }

    .form-row.full {
        grid-template-columns: 1fr;
    }

    .form-actions {
        display: flex;
        gap: 15px;
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
    }

    .form-actions .btn {
        flex: 1;
    }

    .char-count {
        font-size: 12px;
        color: rgba(255, 255, 255, 0.5);
        margin-top: 5px;
    }

    .task-info {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 10px;
        padding: 15px;
        margin-bottom: 20px;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
    }

    .info-item {
        color: rgba(255, 255, 255, 0.7);
        font-size: 12px;
    }

    .info-label {
        font-weight: 600;
        color: white;
        display: block;
        margin-bottom: 3px;
    }

    @media (max-width: 768px) {
        .form-row {
            grid-template-columns: 1fr;
        }

        .form-card {
            padding: 25px;
        }

        .task-info {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')
<div class="form-container">
    <h1 class="form-header">Edit Task</h1>

    <div class="form-card">
        <!-- Task Info -->
        <div class="task-info">
            <div class="info-item">
                <span class="info-label">Status</span>
                <span class="status-badge status-{{ strtolower(str_replace(' ', '', $task->status)) }}">
                    {{ $task->status }}
                </span>
            </div>
            <div class="info-item">
                <span class="info-label">Created</span>
                {{ $task->created_at->format('M d, Y') }}
            </div>
            <div class="info-item">
                <span class="info-label">Last Updated</span>
                {{ $task->updated_at->format('M d, Y H:i') }}
            </div>
            <div class="info-item">
                <span class="info-label">Category</span>
                {{ $task->category->name }}
            </div>
        </div>

        <form action="{{ route('tasks.update', $task) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-row full">
                <div class="form-group">
                    <label for="title" class="form-label">Task Title *</label>
                    <input 
                        type="text" 
                        id="title" 
                        name="title" 
                        class="form-control @error('title') is-invalid @enderror" 
                        placeholder="Enter task title"
                        value="{{ old('title', $task->title) }}"
                        maxlength="255"
                        required
                    >
                    @error('title')
                        <small style="color: #fca5a5;">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="form-row full">
                <div class="form-group">
                    <label for="description" class="form-label">Description</label>
                    <textarea 
                        id="description" 
                        name="description" 
                        class="form-control @error('description') is-invalid @enderror" 
                        placeholder="Add task details..."
                        rows="4"
                        maxlength="1000"
                    >{{ old('description', $task->description) }}</textarea>
                    <div class="char-count"><span id="char-count">{{ strlen(old('description', $task->description ?? '')) }}</span>/1000 characters</div>
                    @error('description')
                        <small style="color: #fca5a5;">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="category_id" class="form-label">Category *</label>
                    <select 
                        id="category_id" 
                        name="category_id" 
                        class="form-control @error('category_id') is-invalid @enderror"
                        required
                    >
                        <option value="">-- Select Category --</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $task->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <small style="color: #fca5a5;">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="priority" class="form-label">Priority *</label>
                    <select 
                        id="priority" 
                        name="priority" 
                        class="form-control @error('priority') is-invalid @enderror"
                        required
                    >
                        <option value="Low" {{ old('priority', $task->priority) === 'Low' ? 'selected' : '' }}>Low</option>
                        <option value="Medium" {{ old('priority', $task->priority) === 'Medium' ? 'selected' : '' }}>Medium</option>
                        <option value="High" {{ old('priority', $task->priority) === 'High' ? 'selected' : '' }}>High</option>
                    </select>
                    @error('priority')
                        <small style="color: #fca5a5;">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="deadline" class="form-label">Deadline</label>
                    <input 
                        type="date" 
                        id="deadline" 
                        name="deadline" 
                        class="form-control @error('deadline') is-invalid @enderror"
                        value="{{ old('deadline', $task->deadline?->format('Y-m-d')) }}"
                    >
                    @error('deadline')
                        <small style="color: #fca5a5;">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="status" class="form-label">Status *</label>
                    <select 
                        id="status" 
                        name="status" 
                        class="form-control @error('status') is-invalid @enderror"
                        required
                    >
                        <option value="To Do" {{ old('status', $task->status) === 'To Do' ? 'selected' : '' }}>To Do</option>
                        <option value="In Progress" {{ old('status', $task->status) === 'In Progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="Completed" {{ old('status', $task->status) === 'Completed' ? 'selected' : '' }}>Completed</option>
                        <option value="Submitted" {{ old('status', $task->status) === 'Submitted' ? 'selected' : '' }}>Submitted</option>
                    </select>
                    @error('status')
                        <small style="color: #fca5a5;">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-success">Update Task</button>
                <a href="{{ route('tasks.index') }}" class="btn" style="background: rgba(255, 255, 255, 0.1); color: white; border: 1px solid rgba(255, 255, 255, 0.2);">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection

@section('extra-js')
<script>
document.getElementById('description').addEventListener('input', function() {
    document.getElementById('char-count').textContent = this.value.length;
});
</script>
@endsection