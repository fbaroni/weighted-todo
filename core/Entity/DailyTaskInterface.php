<?php
namespace Domain\Entity;

interface DailyTaskInterface extends TaskInterface
{
    public function getDate();
}