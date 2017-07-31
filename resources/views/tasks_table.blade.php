<div class="row">
    <div class="col-lg-11 col-md-11 col-sm-11">
        <table class="table">
            <thead class="thead-default">
            <th class="half-col">
                Priority
            </th>
            <th class="medium-col">
                Important
            </th>
            <th class="medium-col">
                Urgent
            </th>
            <th class="medium-col">
                Progress
            </th>
            <th class="col-lg-4 col-md-5 col-sm-6">
                Description
            </th>
            <th class="col-lg-2 col-md-3 col-sm-5">
                When
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
                        <select name="tasks[{{ $task->id }}][important]" class="form-control">
                            <option value="0" {{ $task->important == 0? 'selected' : '' }}>No
                            </option>
                            <option value="1" {{ $task->important == 1? 'selected' : '' }}>Yes
                            </option>
                        </select>
                    </td>
                    <td>
                        <select name="tasks[{{ $task->id }}][urgent]" class="form-control">
                            <option value="0" {{ $task->urgent == 0? 'selected' : '' }}>No
                            </option>
                            <option value="1" {{ $task->urgent == 1? 'selected' : '' }}>Yes
                            </option>
                        </select>
                    </td>
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

                    <td><input type="text" name="tasks[{{ $task->id }}][when]" class="form-control"
                               value="{{ $task->when }}"/></td>
                    <td>
                        <a href="{{ action('TaskController@remove', ['id' => $task->id, 'type' => $type]) }}"
                           class="btn btn-danger">X</a></td>
                </tr>
            @endforeach
            <tr>
                <td><input type="text" name="tasks[new][priority]" class="form-control"/></td>

                <td>
                    <select name="tasks[new][important]" class="form-control">
                        <option value="0">No</option>
                        <option value="1">Yes</option>
                    </select>
                </td>
                <td>
                    <select name="tasks[new][urgent]" class="form-control">
                        <option value="0">No</option>
                        <option value="1">Yes</option>
                    </select>
                </td>
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
                <td><input type="text" name="tasks[new][when]" placeholder="When" class="form-control"/>
                </td>
                <td></td>
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