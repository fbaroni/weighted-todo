<?php
namespace Domain\Entity;

interface MonthlyTaskInterface extends TaskInterface
{
    public function getMonth();
}