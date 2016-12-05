<?php
namespace Domain\Service;

use Domain\Entity\TaskInterface;

class ValuationService
{
    public function getValuation($tasks)
    {
        $totalItems = count($tasks);

        if($totalItems == 0){
            return 0.0;
        }
        $totalPoundered = 0.0;
        $totalDonePoundered = 0.0;

        foreach ($tasks as $task) {
            $totalPoundered += $this->getPounderedTotal($task, $totalItems);
            $totalDonePoundered += $this->getPounderedProgress($task, $totalItems);
        }

        if($totalDonePoundered == 0.0 || $totalPoundered == 0.0){
            return 0.0;
        }

        return ($totalDonePoundered / $totalPoundered) * 100.0;
    }

    private function getPounderedTotal(TaskInterface $task, $totalItems)
    {
        return (1.0 - 1.0 * (($task->getPriority() - 1) / $totalItems));
    }

    private function getPounderedProgress(TaskInterface $task, $totalItems)
    {
        return ($task->getProgress() - $task->getProgress() * (($task->getPriority() - 1.0) / $totalItems));
    }
}