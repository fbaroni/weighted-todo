@extends('base')
@section('content')

    <div class="row">
        <div class="col-lg-1 col-md-1 col-sm-1">
            <h4><a href="{{ action('TaskController@show', ['date' => $yesterday]) }}" class="btn btn-info"
                   role="button">Yesterday</a></h4>
        </div>
        <div class="col-lg-1 col-md-1 col-sm-1">
            <h4><a href="{{ action('TaskController@show', ['date' => $today]) }}" class="btn btn-info" role="button">Today</a>
            </h4>
        </div>
        <div class="col-lg-1 col-md-1 col-sm-1">
            <h4><a href="{{ action('TaskController@show', ['date' => $tomorrow]) }}" class="btn btn-info" role="button">Tomorrow</a>
            </h4>
        </div>
    </div>
    <h2 class="text-center">{{ $tasks['title'] }}</h2>
    <div class="col-lg-12 col-md-12 col-sm-12">
        @include('task_value', ['title' => $date->format('d/m/Y'), 'valuation' => $tasks['valuation'] ])

        <form action="{{ action('TaskController@saveTasks', ['type' => 'day', 'date' => $date->format('Ymd')] ) }}"
              method="post">
            @include('tasks_table', ['tasks' => $tasks['tasks'], 'type' => 'day'  ])
            {{ csrf_field() }}
        </form>
    </div>

    <h2 class="text-center">{{ $weeklyTasks['title'] }}</h2>
    <div class="col-lg-12 col-md-12 col-sm-12">
        @include('task_value', ['title' => 'Week', 'valuation' => $weeklyTasks['valuation'] ])

        <form action="{{ action('TaskController@saveTasks', ['type' => 'week', 'date' => $date->format('Ymd')] ) }}"
              method="post">
            @include('tasks_table', ['tasks' => $weeklyTasks['tasks'], 'type' => 'week'  ])
            {{ csrf_field() }}
        </form>

        <h2 class="text-center">{{ $monthlyTasks['title'] }}</h2>
        @include('task_value', ['title' => 'Month', 'valuation' => $monthlyTasks['valuation'] ])

        <form action="{{ action('TaskController@saveTasks', ['type' => 'month', 'date' => $date->format('Ymd')] ) }}"
              method="post">
            @include('tasks_table', ['tasks' => $monthlyTasks['tasks'], 'type' => 'month' ])
            {{ csrf_field() }}
        </form>
    </div>
    <div class="col-lg-1 col-md-1 col-sm-1">
    </div>
@endsection