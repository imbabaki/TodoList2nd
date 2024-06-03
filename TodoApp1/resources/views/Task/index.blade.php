<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task List</title>
    <link rel="stylesheet" href="/css/main.css">
</head>
<body>

    <h1>Task List</h1>

    <div>
        @if (session()->has('success'))
        <div>
            {{ session('success') }}
        </div>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Description</th>
                <th>Completed</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tasks as $task)
            <tr>
                <td>{{ $task->id }}</td>
                <td>{{ $task->title }}</td>
                <td>{{ $task->description }}</td>
                <td>
                    <form method="post" action="{{ route('task.update', ['task' => $task]) }}">
                        @csrf
                        @method('put')
                        <select name="completed" onchange="this.form.submit()">
                            <option value="0" {{ !$task->completed ? 'selected' : '' }}>No</option>
                            <option value="1" {{ $task->completed ? 'selected' : '' }}>Yes</option>
                        </select>
                    </form>
                </td>
                <td>
                    <a href="{{ route('task.edit', ['task' => $task]) }}" class="button">Edit</a>
                </td>
                <td>
                    <form method="post" action="{{ route('task.destroy', ['task' => $task]) }}">
                        @csrf
                        @method('delete')
                        <input type="submit" value="Delete" class="button button-secondary"/>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="button-container">
        <a href="{{ route('task.create') }}" class="button">Create a New Task</a>
        <a href="{{ route('dashboard') }}" class="button button-secondary">Go Back to Dashboard</a>
    </div>

</body>
</html>
