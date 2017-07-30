<?php
namespace App\Repository;

use App\Model\MonthlyTask;
use App\Model\Task;
use App\Model\WeeklyTask;
use Domain\Service\ValuationService;

class TaskRepository
{
    protected $valuationRepository;
    protected $valuationService;

    /**
     * TaskRepository constructor.
     * @param ValuationRepository $valuationRepository
     */
    public function __construct(ValuationRepository $valuationRepository, ValuationService $valuationService)
    {
        $this->valuationRepository = $valuationRepository;
        $this->valuationService = $valuationService;
    }

    public
    function getTasks(\DateTime $dateTime)
    {
        $dailyTasks = Task::whereDate('date', '=', $dateTime->format('Y-m-d'))
            ->orderBy('priority', 'asc')
            ->get();

        return [
            'tasks' => $dailyTasks,
            'valuation' => $this->getValuationService()->getValuation($dailyTasks),
            'title' => $this->getMainTask($dailyTasks)
        ];
    }

    protected function checkAndSaveLastToCurrent($tasks)
    {

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
        $task->when = $requestTask['when'];
        $task->important = $requestTask['important'];
        $task->urgent = $requestTask['urgent'];

        switch ($type) {
            case 'day':
                $task->date = $dateTime;
                break;
            case 'week':
                $task->week = $dateTime->format("W");
                $task->year = $dateTime->format("Y");
                break;
            case 'month':
                $task->month = $dateTime->format("m");
                $task->year = $dateTime->format("Y");

                break;
        }

        return $task->save();
    }

    protected function getMainTask($taskList)
    {
        foreach ($taskList as $task) {
            if ($task->priority == '1') {
                return $task->name;
            }
        }

        return '';
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
    protected function getTaskByType($idTask, $type)
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
     * @return ValuationRepository
     */
    public function getValuationRepository()
    {
        return $this->valuationRepository;
    }

    /**
     * @return ValuationService
     */
    public function getValuationService()
    {
        return $this->valuationService;
    }
}