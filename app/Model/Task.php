<?php
namespace App\Model;

use Domain\Entity\DailyTaskInterface;
use Illuminate\Database\Eloquent\Model;

class Task extends Model implements DailyTaskInterface
{
    protected $table = 'task';

    public function getProgress()
    {
        return $this->progress;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function getPriority()
    {
        return $this->priority;
    }
}