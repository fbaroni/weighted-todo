<?php
namespace App\Repository;

use App\Model\MonthlyTask;
use App\Model\Task;
use App\Model\WeeklyTask;

class TaskRepository
{
    public function getMonthlyTasks(\DateTime $dateTime)
    {
        $monthNumber = $dateTime->format("m");

        $currentMonthTasks = MonthlyTask::where('month', intval($monthNumber))
            ->orderBy('priority', 'asc')
            ->get();

        return $currentMonthTasks;
    }

    public
    function getWeeklyTasks(\DateTime $dateTime)
    {
        $weekNumber = $dateTime->format("W");

        return WeeklyTask::where('week', intval($weekNumber))
            ->orderBy('priority', 'asc')
            ->get();
    }

    public
    function getTasks(\DateTime $dateTime)
    {
        return Task::whereDate('date', '=', $dateTime->format('Y-m-d'))
            ->orderBy('priority', 'asc')
            ->get();
    }


    public function saveTask($requestTask, $idTask, $type, \DateTime $dateTime)
    {

        $task = $this->getTaskByType($idTask, $type);

        if (!$task) {
            return false;
        }

        $task->priority = $requestTask['priority'] != '' ? $requestTask['priority'] : 0;
        $task->progress = $requestTask['progress'] != '' ? $requestTask['progress'] : 0.0;
        $task->name = $requestTask['name'];

        switch ($type) {
            case 'day':
                $task->date = $dateTime;
                break;
            case 'week':
                $task->week = $dateTime->format("W");
                break;
            case 'month':
                $task->month = $dateTime->format("m");
                break;
        }

        return $task->save();
    }

    public function removeTask($idTask, $type)
    {
        $task = $this->getTaskByType($idTask, $type);

        return $task->forceDelete();
    }


    /**
     * @param $idTask
     * @param $type
     * @return mixed
     */
    private function getTaskByType($idTask, $type)
    {
        $task = false;

        if ($idTask == 'new') {
            switch ($type) {
                case 'day':
                    $task = new Task();
                    break;
                case 'week':
                    $task = new WeeklyTask();
                    break;
                case 'month':
                    $task = new MonthlyTask();
                    break;
            }
        } else {
            switch ($type) {
                case 'day':
                    $task = Task::find($idTask);
                    break;
                case 'week':
                    $task = WeeklyTask::find($idTask);
                    break;
                case 'month':
                    $task = MonthlyTask::find($idTask);
                    break;
            }
        }

        return $task;
    }

}