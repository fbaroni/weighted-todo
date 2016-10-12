<?php
namespace App\Http\Controllers;

use App\Model\Task;

class TaskController extends Controller
{
    public function show()
    {
        $tasks = Task::all();

        var_dump($tasks);exit;
    }
}
