<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource with Search, Filter, and Sort capabilities.
     */
    public function index(Request $request): View
    {
        // 1. Build the base query with relationships
        $query = Task::with('category')->where('deleted_at', null);

        // 2. Filter by Status (handles both route parameters and query strings)
        $statusParam = $request->route('status') ?? $request->get('status');
        if ($statusParam && $statusParam !== 'All') {
            $query->where('status', $statusParam);
        }

        // 3. Handle Search (Title or Description)
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('description', 'LIKE', "%{$searchTerm}%");
            });
        }

        // 4. Filter by Priority
        if ($request->filled('priority') && $request->priority !== 'All') {
            $query->where('priority', $request->priority);
        }

        // 5. Filter by Category
        if ($request->filled('category') && $request->category !== 'All') {
            $query->where('category_id', $request->category);
        }

        // 6. Filter by Deadline (upcoming or overdue)
        if ($request->filled('deadline_filter')) {
            if ($request->deadline_filter === 'overdue') {
                $query->whereDate('deadline', '<', today())
                      ->whereNotNull('deadline');
            } elseif ($request->deadline_filter === 'today') {
                $query->whereDate('deadline', today());
            } elseif ($request->deadline_filter === 'upcoming') {
                $query->whereDate('deadline', '>', today());
            }
        }

        // 7. Handle Sorting
        $sortField = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');
        
        // Security check: Validate sort field to prevent SQL injection
        $allowedSorts = ['title', 'priority', 'deadline', 'status', 'created_at', 'category_id'];
        if (in_array($sortField, $allowedSorts)) {
            $query->orderBy($sortField, $sortDirection);
        } else {
            $query->latest();
        }

        // 8. Get supporting data for counters and sidebar
        $allTasks = Task::where('deleted_at', null)->get();
        $categories = Category::all();
        $todayTasks = Task::where('deleted_at', null)->whereDate('deadline', today())->get();
        $upcomingTasks = Task::where('deleted_at', null)->whereDate('deadline', '>', today())->get();
        $overdueTasks = Task::where('deleted_at', null)->whereDate('deadline', '<', today())->whereNotNull('deadline')->get();

        return view('tasks.index', [
            'tasks' => $query->get(), 
            'categories' => $categories,
            'todayTasks' => $todayTasks,
            'upcomingTasks' => $upcomingTasks,
            'overdueTasks' => $overdueTasks,
            'allTasks' => $allTasks,
            'currentStatus' => $statusParam ?? 'All',
        ]);
    }

    /**
     * Display deleted tasks (soft deleted)
     */
    public function deleted(): View
    {
        $deletedTasks = Task::with('category')->onlyTrashed()->get();
        $categories = Category::all();

        return view('tasks.deleted', [
            'tasks' => $deletedTasks,
            'categories' => $categories,
        ]);
    }

    /**
     * Restore a soft deleted task
     */
    public function restore($id): RedirectResponse
    {
        $task = Task::onlyTrashed()->findOrFail($id);
        $task->restore();

        return redirect()->route('tasks.deleted')->with('success', 'Task restored successfully!');
    }

    /**
     * Permanently delete a soft deleted task
     */
    public function forceDelete($id): RedirectResponse
    {
        $task = Task::onlyTrashed()->findOrFail($id);
        $task->forceDelete();

        return redirect()->route('tasks.deleted')->with('success', 'Task permanently deleted!');
    }

    /**
     * Redirects to index logic for cleaner status-based routing.
     */
    public function getByStatus($status): View
    {
        return $this->index(request());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $categories = Category::all();
        return view('tasks.create', ['categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'priority' => 'required|in:Low,Medium,High',
            'deadline' => 'nullable|date|after:today',
            'status' => 'required|in:To Do,In Progress,Completed,Submitted',
        ]);

        Task::create($validated);

        return redirect()->route('tasks.index')->with('success', 'Task created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task): View
    {
        return view('tasks.show', ['task' => $task]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task): View
    {
        $categories = Category::all();
        return view('tasks.edit', [
            'task' => $task,
            'categories' => $categories,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'priority' => 'required|in:Low,Medium,High',
            'deadline' => 'nullable|date',
            'status' => 'required|in:To Do,In Progress,Completed,Submitted',
        ]);

        $task->update($validated);

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully!');
    }

    /**
     * Soft delete the resource (mark as deleted but keep in database)
     */
    public function destroy(Task $task): RedirectResponse
    {
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Task deleted and moved to trash!');
    }

    /**
     * Update task status via AJAX (Patch)
     */
    public function updateStatus(Request $request, Task $task)
    {
        $validated = $request->validate([
            'status' => 'required|in:To Do,In Progress,Completed,Submitted',
        ]);

        $task->update($validated);

        return response()->json(['success' => true, 'message' => 'Status updated!']);
    }
}