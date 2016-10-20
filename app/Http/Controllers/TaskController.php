<?php
namespace App\Http\Controllers;

use App\Model\MonthlyTask;
use App\Model\Task;
use App\Model\WeeklyTask;

class TaskController extends Controller
{
    public function show($timeStamp = '')
    {
        $dateTime = $timeStamp == ''? (new \DateTime('now')) : '';

        if($timeStamp == ''){

        }

        $dateTime = new \DateTime('now');

        $weeklyTasks = $this->getWeeklyTasks($dateTime);
        $monthlyTasks = $this->getMonthlyTasks($dateTime);
        $tasks = $this->getTasks($dateTime);
        return view('tasks',
            [
                'tasks' => $tasks,
                'weeklyTasks' => $weeklyTasks,
                'monthlyTasks' => $monthlyTasks,
            ]);
    }

    private function getMonthlyTasks(\DateTime $dateTime)
    {
        $monthNumber = $dateTime->format("m");

        return  MonthlyTask::where('month', intval($monthNumber))
            ->orderBy('priority', 'desc')
            ->get();
    }

    private function getWeeklyTasks(\DateTime $dateTime)
    {
        $weekNumber = $dateTime->format("W");

        return  WeeklyTask::where('week', intval($weekNumber))
            ->orderBy('priority', 'desc')
            ->get();
    }

    private function getTasks(\DateTime $dateTime)
    {
        return  Task::whereDate('date', '=', $dateTime->format('Y-m-d'))
            ->orderBy('priority', 'desc')
            ->get();
    }
}
