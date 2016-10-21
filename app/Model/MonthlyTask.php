<?php
namespace App\Model;

use Domain\Entity\MonthlyTaskInterface;
use Illuminate\Database\Eloquent\Model;

class MonthlyTask extends Model implements MonthlyTaskInterface
{
    protected $table = 'monthly_task';

    public function getProgress()
    {
        return $this->progress;
    }

    public function getMonth()
    {
        return $this->month;
    }

    public function getPriority()
    {
        return $this->priority;
    }
}