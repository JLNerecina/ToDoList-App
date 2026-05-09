<nav class="navbar">
    <div class="navbar-brand">
        TaskFlow
    </div>
    <ul class="nav-menu">
        <li>
            <a href="{{ route('tasks.index') }}" class="nav-link {{ request()->routeIs('tasks.index') ? 'active' : '' }}">
                Home
            </a>
        </li>
        <li>
            <a href="{{ route('tasks.byStatus', 'To Do') }}" class="nav-link {{ request()->routeIs('tasks.byStatus') && request()->route('status') === 'To Do' ? 'active' : '' }}">
                To Do
            </a>
        </li>
        <li>
            <a href="{{ route('tasks.byStatus', 'In Progress') }}" class="nav-link {{ request()->routeIs('tasks.byStatus') && request()->route('status') === 'In Progress' ? 'active' : '' }}">
                In Progress
            </a>
        </li>
        <li>
            <a href="{{ route('tasks.byStatus', 'Completed') }}" class="nav-link {{ request()->routeIs('tasks.byStatus') && request()->route('status') === 'Completed' ? 'active' : '' }}">
                Completed
            </a>
        </li>
        <li>
            <a href="{{ route('tasks.byStatus', 'Submitted') }}" class="nav-link {{ request()->routeIs('tasks.byStatus') && request()->route('status') === 'Submitted' ? 'active' : '' }}">
                Submitted
            </a>
        </li>
        <li>
            <a href="{{ route('tasks.deleted') }}" class="nav-link {{ request()->routeIs('tasks.deleted') ? 'active' : '' }}">
                Trash
            </a>
        </li>
        <li>
            <a href="{{ route('tasks.create') }}" class="btn btn-primary btn-sm">
                Add Task
            </a>
        </li>
    </ul>
</nav>