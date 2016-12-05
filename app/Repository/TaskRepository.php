<?php
namespace App\Repository;

use App\Model\MonthlyTask;
use App\Model\Task;
use App\Model\WeeklyTask;
use Domain\Service\ValuationService;

class TaskRepository
{
    protected $valuationService;

    /**
     * TaskRepository constructor.
     * @param ValuationService $valuationService
     */
    public function __construct(ValuationService $valuationService)
    {
        $this->valuationService = $valuationService;
    }


    public function getMonthlyTasks(\DateTime $dateTime)
    {
        $monthNumber = intval($dateTime->format("m"));
        $yearNumber = intval($dateTime->format("Y"));

        $postponedMonthTasks = $this->getOneDifferenceMonth($monthNumber, $yearNumber, 'restar');
        //TODO check postponed and save like current if not in 100 %. has the problem of deleting
        //TODO in order to solve this we are "marking" if a task has been postponed. you can postpone one time only

        $currentMonthTasks = MonthlyTask::where('month', intval($monthNumber))
            ->orderBy('priority', 'asc')
            ->get();

        return ['tasks' => $currentMonthTasks, 'valuation' => $this->getValuationService()->getValuation($currentMonthTasks)];
    }

    public
    function getWeeklyTasks(\DateTime $dateTime)
    {
        $weekNumber = $dateTime->format("W");

        $weeklyTasks =  WeeklyTask::where('week', intval($weekNumber))
            ->orderBy('priority', 'asc')
            ->get();

        return ['tasks' => $weeklyTasks, 'valuation' => $this->getValuationService()->getValuation($weeklyTasks)];

    }

    public
    function getTasks(\DateTime $dateTime)
    {
        $dailyTasks =  Task::whereDate('date', '=', $dateTime->format('Y-m-d'))
            ->orderBy('priority', 'asc')
            ->get();

        return ['tasks' => $dailyTasks, 'valuation' => $this->getValuationService()->getValuation($dailyTasks)];
    }

    private function getMonthlyTasksByMonthYear($month, $year)
    {
        return MonthlyTask::where('month', $month)
            ->where('year', $year)
            ->orderBy('priority', 'asc')
            ->get();
    }

    private function getWeeklyTasksByWeekYear($week, $year)
    {
        return WeeklyTask::where('week', $week)
            ->where('year', $year)
            ->orderBy('priority', 'asc')
            ->get();
    }

    private function checkAndSaveLastToCurrent($tasks)
    {

    }


    private function getOneDifferenceWeek($week, $year, $operation)
    {
        if ($operation == 'restar') {
            --$week;
        } else {
            ++$week;
        }

        if ($week == 0) {
            $week = 52;
            --$year;
        }

        if ($week == 53) {
            $week = 1;
            ++$year;
        }

        return ['week' => $week, 'year' => $year];
    }

    private function getOneDifferenceMonth($month, $year, $operation)
    {
        if ($operation == 'restar') {
            --$month;
        } else {
            ++$month;
        }

        if ($month == 0) {
            $month = 12;
            --$year;
        }

        if ($month == 13) {
            $month = 1;
            ++$year;
        }

        return ['month' => $month, 'year' => $year];
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

    /**
     * @return ValuationService
     */
    public function getValuationService()
    {
        return $this->valuationService;
    }
}