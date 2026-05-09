<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo App</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="max-w-md w-full bg-white shadow-lg rounded-lg p-8 text-center">
        <h1 class="text-3xl font-bold text-gray-800 mb-4">✅ Todo App</h1>
        <p class="text-gray-600 mb-6">
            Your Laravel application is back online. Time to get some tasks done!
        </p>
        <div class="space-y-4">
            <a href="/tasks" class="block w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded transition">
                View My Tasks
            </a>
            <p class="text-xs text-gray-400">
                Current Laravel Version: {{ Illuminate\Foundation\Application::VERSION }}
            </p>
        </div>
    </div>
</body>
</html>