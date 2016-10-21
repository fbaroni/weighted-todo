<?php
namespace Domain\Entity;

interface WeeklyTaskInterface extends TaskInterface
{
    public function getWeek();
}