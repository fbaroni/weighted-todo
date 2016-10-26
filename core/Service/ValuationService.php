<?php
namespace Domain\Service;

use Domain\Entity\TaskInterface;

class ValuationService
{
    static public function getValuation($tasks)
    {
        $totalItems = count($tasks);
        if($totalItems == 0){
            return 0.0;
        }
        $totalPoundered = 0.0;
        $totalDonePoundered = 0.0;

        foreach ($tasks as $task) {
            $totalPoundered += self::getPounderedTotal($task, $totalItems);
            $totalDonePoundered += self::getPounderedProgress($task, $totalItems);
        }

        if($totalDonePoundered == 0.0 || $totalPoundered == 0.0){
            return 0.0;
        }
        return ($totalDonePoundered / $totalPoundered) * 100.0;
    }


    static private function getPounderedTotal(TaskInterface $task, $totalItems)
    {
        return (1.0 - 1.0 * (($task->getPriority() - 1) / $totalItems));
    }

    static private function getPounderedProgress(TaskInterface $task, $totalItems)
    {
        return ($task->getProgress() - $task->getProgress() * (($task->getPriority() - 1.0) / $totalItems));
    }
}