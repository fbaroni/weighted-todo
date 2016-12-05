<div class="row">
    <div class="col-lg-11 col-md-11 col-sm-11">
        <table class="table">
            <thead class="thead-default">
            <th class="half-col">
                Priority
            </th>
            <th class="medium-col">
                Progress
            </th>
            <th class="col-lg-5 col-md-6 col-sm-7">
                Description
            </th>
            <th class="col-lg-1 col-md-1 col-sm-1"></th>
            </thead>
            <tbody>
            <tr>
                <h4></h4>
            </tr>
            @foreach ($tasks as $task)
                <tr>
                    <td><input type="text" name="tasks[{{ $task->id }}][priority]"
                               value="{{ $task->priority }}" class="form-control"/></td>
                    <td>
                        <select name="tasks[{{ $task->id }}][progress]" class="form-control">
                            <option value="0.0" {{ $task->progress == 0.0? 'selected' : '' }}>0 %
                            </option>
                            <option value="0.33" {{ $task->progress == 0.33? 'selected' : '' }}>33 %
                            </option>
                            <option value="1.0" {{ $task->progress == 1.0? 'selected' : '' }}>100 %
                            </option>
                        </select>
                    </td>
                    <td><input type="text" name="tasks[{{ $task->id }}][name]" class="form-control"
                               value="{{ $task->name }}"/></td>
                    <td>
                        <a href="{{ action('TaskController@remove', ['id' => $task->id, 'type' => $type]) }}"
                           class="btn btn-danger">X</a></td>
                </tr>
            @endforeach
            <tr>
                <td><input type="text" name="tasks[new][priority]" class="form-control"/></td>
                <td>
                    <select name="tasks[new][progress]" class="form-control">
                        <option value="0.0">0 %
                        </option>
                        <option value="0.33">33 %
                        </option>
                        <option value="1.0">100 %
                        </option>
                    </select>
                </td>
                <td><input type="text" name="tasks[new][name]" placeholder="New Task" class="form-control"/>
                </td>
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