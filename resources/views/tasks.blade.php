@extends('base')
@section('content')
    <div class="col-lg-1 col-md-1 col-sm-1">
    </div>
    <div class="col-lg-8 col-md-10 col-sm-12">

        <div class="row">
            <div class="col-lg-2 col-md-2 col-sm-2">
                <h2>Today</h2>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
                @if($valuation > 60.0)
                    <h1 class="text-success">
                        @elseif($valuation > 35.0)
                            <h1 class="text-warning">
                                @else
                                    <h1 class="text-danger">
                                        @endif
                                        {{ round($valuation, 2) }}&nbsp; %</h1>
            </div>
        </div>
        <form action="{{ action('TaskController@saveTasks', array('type' => 'day') ) }}" method="post">
            <div class="row">
                <div class="col-lg-11 col-md-11 col-sm-11">
                    <table class="table">
                        <thead class="thead-default">
                        <th class="col-lg-1 col-md-1 col-sm-1">
                            Priority
                        </th>
                        <th class="col-lg-4 col-md-5 col-sm-6">
                            Description
                        </th>
                        <th class="col-lg-1 col-md-1 col-sm-1">
                            Progress
                        </th>
                        </thead>
                        <tbody>
                        @foreach ($tasks as $task)
                            <tr>
                                <td><input type="text" name="tasks[{{ $task->id }}][priority]" class="form-control"
                                           value="{{ $task->priority }}"/></td>
                                <td><input type="text" name="tasks[{{ $task->id }}][name]" class="form-control"
                                           value="{{ $task->name }}"/></td>
                                {{--<td><input type="text" name="tasks[{{ $task->id }}][description]" class="form-control"--}}
                                           {{--value="{{ $task->description }}"/></td>--}}
                                <td><input type="text" name="tasks[{{ $task->id }}][progress]" class="form-control"
                                           value="{{ $task->progress }}"/></td>
                            </tr>
                        @endforeach
                        <tr>
                            <td><input type="text" name="tasks[new][priority]" class="form-control"/></td>
                            <td><input type="text" name="tasks[new][name]" placeholder="New Task" class="form-control"/>
                            </td>
                            {{--<td><input type="text" name="tasks[new][description]" class="form-control"/></td>--}}
                            <td><input type="text" name="tasks[new][progress]" class="form-control"/></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-1 col-md-1 col-sm-1">
                    <input type="submit" class="btn btn-success" value="Save"/>
                </div>
            </div>
            {{ csrf_field() }}
        </form>
        <div class="row">
            <div class="col-lg-2 col-md-2 col-sm-2">
                <h2>Week</h2>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
                @if($weekValuation > 60.0)
                    <h1 class="text-success">
                        @elseif($weekValuation > 35.0)
                            <h1 class="text-warning">
                                @else
                                    <h1 class="text-danger">
                                        @endif
                                        {{ round($weekValuation, 2) }}&nbsp; %</h1>
            </div>
        </div>
        <form action="{{ action('TaskController@saveTasks', array('type' => 'week') ) }}" method="post">
            <div class="row">
                <div class="col-lg-11 col-md-11 col-sm-11">
                    <table class="table">
                        <thead class="thead-default">
                        <th class="col-lg-1 col-md-1 col-sm-1">
                            Priority
                        </th>
                        <th class="col-lg-4 col-md-5 col-sm-6">
                            Description
                        </th>
                        <th class="col-lg-1 col-md-1 col-sm-1">
                            Progress
                        </th>
                        </thead>
                        <tbody>
                        @foreach ($weeklyTasks as $task)
                            <tr>
                                <td><input type="text" name="tasks[{{ $task->id }}][priority]" class="form-control"
                                           value="{{ $task->priority }}"/></td>
                                <td><input type="text" name="tasks[{{ $task->id }}][name]" class="form-control"
                                           value="{{ $task->name }}"/></td>
                                {{--<td><input type="text" name="tasks[{{ $task->id }}][description]" class="form-control"--}}
                                           {{--value="{{ $task->description }}"/></td>--}}
                                <td><input type="text" name="tasks[{{ $task->id }}][progress]" class="form-control"
                                           value="{{ $task->progress }}"/></td>
                            </tr>
                        @endforeach
                        <tr>
                            <td><input type="text" name="tasks[new][priority]" class="form-control"/></td>
                            <td><input type="text" name="tasks[new][name]" placeholder="New Task" class="form-control"/>
                            </td>
                            {{--<td><input type="text" name="tasks[new][description]" class="form-control"/></td>--}}
                            <td><input type="text" name="tasks[new][progress]" class="form-control"/></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-1 col-md-1 col-sm-1">
                    <input type="submit" class="btn btn-success" value="Save"/>
                </div>
            </div>
            {{ csrf_field() }}
        </form>
        <div class="col-lg-2 col-md-2 col-sm-2">
            <h2>Month</h2>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6">
            @if($monthValuation > 60.0)
                <h1 class="text-success">
                    @elseif($monthValuation > 35.0)
                        <h1 class="text-warning">
                            @else
                                <h1 class="text-danger">
                                    @endif
                                    {{ round($monthValuation, 2) }}&nbsp; %</h1>
        </div>
        <form action="{{ action('TaskController@saveTasks', array('type' => 'month') ) }}" method="post">
            <div class="row">
                <div class="col-lg-11 col-md-11 col-sm-11">
                    <table class="table">
                        <thead class="thead-default">
                        <th class="col-lg-1 col-md-1 col-sm-1">
                            Priority
                        </th>
                        <th class="col-lg-4 col-md-5 col-sm-6">
                            Description
                        </th>
                        <th class="col-lg-1 col-md-1 col-sm-1">
                            Progress
                        </th>
                        </thead>
                        <tbody>
                        @foreach ($monthlyTasks as $task)
                            <tr>
                                <td><input type="text" name="tasks[{{ $task->id }}][priority]" class="form-control"
                                           value="{{ $task->priority }}"/></td>
                                <td><input type="text" name="tasks[{{ $task->id }}][name]" class="form-control"
                                           value="{{ $task->name }}"/></td>
                                {{--<td><input type="text" name="tasks[{{ $task->id }}][description]" class="form-control"--}}
                                           {{--value="{{ $task->description }}"/></td>--}}
                                <td><input type="text" name="tasks[{{ $task->id }}][progress]" class="form-control"
                                           value="{{ $task->progress }}"/></td>
                            </tr>
                        @endforeach
                        <tr>
                            <td><input type="text" name="tasks[new][priority]" class="form-control"/></td>
                            <td><input type="text" name="tasks[new][name]" placeholder="New Task" class="form-control"/>
                            </td>
                            {{--<td><input type="text" name="tasks[new][description]" class="form-control"/></td>--}}
                            <td><input type="text" name="tasks[new][progress]" class="form-control"/></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-1 col-md-1 col-sm-1">
                    <input type="submit" class="btn btn-success" value="Save"/>
                </div>
            </div>
            {{ csrf_field() }}
        </form>
    </div>
    <div class="col-lg-1 col-md-1 col-sm-1">
    </div>
@endsection