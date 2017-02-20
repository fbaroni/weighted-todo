<?php
namespace App\Repository;

use App\Model\Task;

class DailyTaskRepository extends TaskRepository
{
    public function getDailyTasks(\DateTime $dateTime)
    {
        $this->getOneDifferenceDailyTasks($dateTime);

        $daylyTasks = $this->getDailyTasksByDate($dateTime);

        return [
            'tasks' => $daylyTasks,
            'valuation' => $this->getValuationService()->getValuation($daylyTasks),
            'title' => $this->getMainTask($daylyTasks)
        ];
    }

    private function getDailyTasksByDate(\DateTime $dateTime)
    {
        return Task::whereDate('date', '=', $dateTime->format('Y-m-d'))
            ->orderBy('priority', 'asc')
            ->get();
    }

    private function getOneDifferenceDailyTasks($datetime)
    {
        $differenceDay = $this->getOneDifferenceDay($datetime);

        $notDoneDailyTasks = $this->getDailyTasksByDate($differenceDay);

        foreach ($notDoneDailyTasks as $notDoneDailyTask) {

            if ($notDoneDailyTask->progress < 1.0) {
                $task = new Task();

                foreach ($notDoneDailyTask->getAttributes() as $key => $value) {

                    if ($key == 'id') {
                        continue;
                    } elseif ($key == 'date') {
                        $task->date = $datetime;
                    } elseif ($key == 'progress') {
                        $task->progress = 0.0;
                    } else {
                        $task->$key = $value;
                    }
                }
                if ($this->checkIfDailyTaskNotExist($task)) {
                    $task->save();
                }
            }
        }
    }

    private function checkIfDailyTaskNotExist(Task $task)
    {
        $tasks = Task::whereDate('date', '=', $task->date->format('Y-m-d'))
            ->orderBy('priority', 'asc')
            ->where('name', $task->name)
            ->get();

        return count($tasks) == 0;
    }


    private function getOneDifferenceDay(\DateTime $dateTime)
    {
        $OneDayDifferenceDateTime = clone $dateTime;
        $OneDayDifferenceDateTime->modify('-1 day');

        return $OneDayDifferenceDateTime;
    }
}