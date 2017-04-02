<?php
namespace App\Repository;

use App\Model\WeeklyTask;

class WeeklyTaskRepository extends TaskRepository
{
    public function getWeeklyTasks(\DateTime $dateTime)
    {
        $weekNumber = intval($dateTime->format("W"));
        $yearNumber = intval($dateTime->format("Y"));

        $weeklyTasks = $this->getWeeklyTasksByWeekYear($weekNumber, $yearNumber);

        return [
            'tasks' => $weeklyTasks,
            'valuation' => $this->getValuationService()->getValuation($weeklyTasks),
            'title' => $this->getMainTask($weeklyTasks)
        ];
    }

    private function getWeeklyTasksByWeekYear($week, $year)
    {
        return WeeklyTask::where('week', intval($week))
            ->where('year', intval($year))
            ->orderBy('priority', 'asc')
            ->get();
    }

    private function getOneDifferenceWeeklyTasks($week, $year, $operation)
    {
        $yearWeek = $this->getOneDifferenceWeek($week, $year, $operation);

        
        $notDoneWeeklyTasks = WeeklyTask::where('week', $yearWeek['week'])
            ->where('year', $yearWeek['year'])
            ->orderBy('priority', 'asc')
            ->get();

        foreach ($notDoneWeeklyTasks as $notDoneWeeklyTask) {

            if($notDoneWeeklyTask->progress < 1.0) {
                $task = new WeeklyTask();

                foreach ($notDoneWeeklyTask->getAttributes() as $key => $value) {

                    if ($key == 'id') {
                        continue;
                    } elseif ($key == 'week'
                    ) {
                        $task->week = $week;
                    } elseif ($key == 'year') {
                        $task->year = $year;
                    } elseif ($key == 'progress') {
                        $task->progress = 0.0;
                    }else {
                        $task->$key = $value;
                    }
                }
                if($this->checkIfWeeklyTaskNotExist($task)){
                    $task->save();
                }
            }
        }
    }

    private function checkIfWeeklyTaskNotExist(WeeklyTask $task)
    {
        $tasks = WeeklyTask::where('week', $task->getWeek())
            ->where('year', $task->year)
            ->where('name', $task->name)
            ->get();

        return count($tasks) == 0;
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
}