<?php
namespace App\Http\Controllers;

use App\Model\MonthlyTask;
use App\Model\Task;
use App\Model\WeeklyTask;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function show(Request $request)
    {
        $timeStamp = $request->get('timestamp');

        $dateTime = $timeStamp == '' ? (new \DateTime('now')) : '';

        if ($timeStamp == '') {

        }

        $weeklyTasks = $this->getWeeklyTasks($dateTime);
        $monthlyTasks = $this->getMonthlyTasks($dateTime);
        $tasks = $this->getTasks($dateTime);


        return view('tasks',
            [
                'tasks' => $tasks,
                'weeklyTasks' => $weeklyTasks,
                'monthlyTasks' => $monthlyTasks,
                'valuation' => $this->getValuation($tasks)
            ]);
    }

    public function saveTasks(Request $request)
    {
        if ($request->isMethod('POST')) {
            foreach ($request->request->get('tasks') as $index => $requestTask) {
                if ($requestTask['priority'] == '') {
                    continue;
                }
                $this->saveTask($requestTask, $index);
            }

            return redirect()->route('show');
        }
    }

    private function saveTask($requestTask, $indexTask)
    {
        $task = $indexTask == 'new' ? new Task() : Task::find($indexTask);

        if (!$task) {
            //TODO throw new AppException
            throw new \Exception('no se creó la tarea');

        }
        $task->priority = $requestTask['priority'];
        $task->progress = $requestTask['progress'];
        $task->name = $requestTask['name'];
        $task->description = $requestTask['description'];
        $task->date = new \DateTime('now');

        return $task->save();
    }

    private function getValuation($tasks)
    {
        $totalItems = count($tasks);
        var_dump($totalItems);
        $totalPoundered = 0.0;
        $totalDonePoundered = 0.0;

        foreach ($tasks as $task) {
            $totalPoundered += (1.0 - 1.0 * (($task->priority - 1) / $totalItems));
            $totalDonePoundered += ($task->progress - $task->progress*(($task->priority - 1.0) / $totalItems));
        }

        return ($totalDonePoundered / $totalPoundered ) * 100.0;
    }

    private
    function getMonthlyTasks(\DateTime $dateTime)
    {
        $monthNumber = $dateTime->format("m");

        return MonthlyTask::where('month', intval($monthNumber))
            ->orderBy('priority', 'asc')
            ->get();
    }

    private
    function getWeeklyTasks(\DateTime $dateTime)
    {
        $weekNumber = $dateTime->format("W");

        return WeeklyTask::where('week', intval($weekNumber))
            ->orderBy('priority', 'asc')
            ->get();
    }

    private
    function getTasks(\DateTime $dateTime)
    {
        return Task::whereDate('date', '=', $dateTime->format('Y-m-d'))
            ->orderBy('priority', 'asc')
            ->get();
    }
}
