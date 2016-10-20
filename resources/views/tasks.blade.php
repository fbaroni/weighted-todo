@extends('base')
@section('content')
    <h3>Today</h3>
    <table class="table">
        <thead class="thead-default">
        <th>
            Priority
        </th>
        <th>
            Name
        </th>
        <th>
            Description
        </th>
        <th>
            Progress
        </th>
        </thead>
        <tbody>
        @foreach ($tasks as $task)
            <tr>
                <td>{{ $task->priority }}</td>
                <td>{{ $task->name }}</td>
                <td>{{ $task->description }}</td>
                <td>{{ $task->progress }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <h3>Week</h3>
    <table class="table">
        <thead class="thead-inverse">
        <th>
            Priority
        </th>
        <th>
            Name
        </th>
        <th>
            Description
        </th>
        <th>
            Progress
        </th>
        </thead>
        <tbody>
        @foreach ($weeklyTasks as $task)
            <tr>
                <td>{{ $task->priority }}</td>
                <td>{{ $task->name }}</td>
                <td>{{ $task->description }}</td>
                <td>{{ $task->progress }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <h3>Month</h3>
    <table class="table">
        <thead class="thead-inverse">
        <th>
            Priority
        </th>
        <th>
            Name
        </th>
        <th>
            Description
        </th>
        <th>
            Progress
        </th>
        </thead>
        <tbody>
        @foreach ($monthlyTasks as $task)
            <tr>
                <td>{{ $task->priority }}</td>
                <td>{{ $task->name }}</td>
                <td>{{ $task->description }}</td>
                <td>{{ $task->progress }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection