<?php
namespace App\Repository;

use App\Model\MonthlyTask;
use App\Model\Task;
use App\Model\WeeklyTask;
use Domain\Service\ValuationService;

class MonthlyTaskRepository extends TaskRepository
{
    public function getMonthlyTasks(\DateTime $dateTime)
    {
        $monthNumber = intval($dateTime->format("m"));
        $yearNumber = intval($dateTime->format("Y"));

        $this->getOneDifferenceMonthlyTasks($monthNumber, $yearNumber, 'restar');
        //TODO check postponed and save like current if not in 100 %. has the problem of deleting
        //TODO in order to solve this we are "marking" if a task has been postponed. you can postpone one time only

        $currentMonthTasks = MonthlyTask::where('month', intval($monthNumber))
            ->where('year', intval($yearNumber))
            ->orderBy('priority', 'asc')
            ->get();

        return [
            'tasks' => $currentMonthTasks,
            'valuation' => $this->getValuationRepository()->calculateMonthValuation($dateTime, $currentMonthTasks),
            'title' => $this->getMainTask($currentMonthTasks)
        ];
    }

    private function getMonthlyTasksByMonthYear($month, $year)
    {
        return MonthlyTask::where('month', $month)
            ->where('year', $year)
            ->orderBy('priority', 'asc')
            ->get();
    }

    private function getOneDifferenceMonthlyTasks($month, $year, $operation)
    {
        $yearMonth = $this->getOneDifferenceMonth($month, $year, $operation);

        $notDoneMonthlyTasks = MonthlyTask::where('month', $yearMonth['month'])
            ->where('year', $yearMonth['year'])
            ->orderBy('priority', 'asc')
            ->get();

        foreach ($notDoneMonthlyTasks as $notDoneMontlyTask) {

            if($notDoneMontlyTask->progress < 1.0) {
                $task = new MonthlyTask();

                foreach ($notDoneMontlyTask->getAttributes() as $key => $value) {

                    if ($key == 'id') {
                        continue;
                    } elseif ($key == 'month'
                    ) {
                        $task->month = $month;
                    } elseif ($key == 'year') {
                        $task->year = $year;
                    } else {
                        $task->$key = $value;
                    }
                }
                if($this->checkIfMonthlyTaskNotExist($task)){
                    $task->save();
                }
            }
        }
    }

    private function checkIfMonthlyTaskNotExist(MonthlyTask $task)
    {
        $tasks = MonthlyTask::where('month', $task->getMonth())
            ->where('year', $task->year)
            ->where('name', $task->name)
            ->get();

        return count($tasks) == 0;
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
}