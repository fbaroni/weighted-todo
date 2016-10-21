<?php
namespace App\Model;

use Domain\Entity\WeeklyTaskInterface;
use Illuminate\Database\Eloquent\Model;

class WeeklyTask extends Model implements WeeklyTaskInterface
{
    protected $table = 'weekly_task';

    public function getProgress()
    {
        return $this->progress;
    }

    public function getWeek()
    {
        return $this->week;
    }

    public function getPriority()
    {
        return $this->priority;
    }
}