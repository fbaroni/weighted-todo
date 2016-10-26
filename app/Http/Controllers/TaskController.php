<?php
namespace App\Http\Controllers;

use App\Model\MonthlyTask;
use App\Model\Task;
use App\Model\WeeklyTask;
use Illuminate\Http\Request;
use Domain\Service\ValuationService;

class TaskController extends Controller
{
    public function show(Request $request)
    {
        $date = $request->get('date');
        $dateTime = $date == '' ? (new \DateTime('now')) : ($this->getDateTimeFromString($date));

        $weeklyTasks = $this->getWeeklyTasks($dateTime);
        $monthlyTasks = $this->getMonthlyTasks($dateTime);
        $tasks = $this->getTasks($dateTime);

        return view('tasks',
            [
                'tasks' => $tasks,
                'weeklyTasks' => $weeklyTasks,
                'monthlyTasks' => $monthlyTasks,
                'valuation' => ValuationService::getValuation($tasks),
                'weekValuation' => ValuationService::getValuation($weeklyTasks),
                'monthValuation' => ValuationService::getValuation($monthlyTasks),
                'tomorrow' => $this->getTomorrowDate(),
                'yesterday' => $this->getYesterdayDate(),
                'today' => $this->getTodayDate(),
                'date' => $dateTime
            ]);
    }

    private function getYesterdayDate()
    {
        $today = new \DateTime('yesterday');

        return $today->format('Ymd');
    }

    private function getTomorrowDate()
    {
        $today = new \DateTime('tomorrow');

        return $today->format('Ymd');
    }

    private function getTodayDate()
    {
        $today = new \DateTime('now');

        return $today->format('Ymd');
    }

    public function saveTasks(Request $request, $type, $dateTimeString)
    {
        $dateTime = $this->getDateTimeFromString($dateTimeString);

        if ($request->isMethod('POST')) {
            foreach ($request->request->get('tasks') as $index => $requestTask) {
                if ($requestTask['priority'] == '') {
                    continue;
                }
                $this->saveTask($requestTask, $index, $type, $dateTime);
            }

            return redirect()->route('show', ['date' => $dateTimeString]);
        }
    }


    public function remove($idTask, $type)
    {
        $task = $this->getTaskByType($idTask, $type);

        $task->forceDelete();

        return redirect()->route('show');
    }

    public function postpone($idTask, $type, $dateTimeString)
    {
        $dateTime = $this->getDateTimeFromString($dateTimeString);

        $task = $this->getTaskByType($idTask, $type);

        $task->forceDelete();

        return redirect()->route('show');
    }

    private function saveTask($requestTask, $idTask, $type, \DateTime $dateTime)
    {

        $task = $this->getTaskByType($idTask, $type);

        if (!$task) {
            return false;
        }

        $task->priority = $requestTask['priority'] != '' ? $requestTask['priority'] : 0;
        $task->progress = $requestTask['progress'] != '' ? $requestTask['progress'] : 0.0;
        $task->name = $requestTask['name'];
//        $task->description = $requestTask['description'];

        switch ($type) {
            case 'day':
                $task->date = $dateTime;
                break;
            case 'week':
                $task->week = $dateTime->format("W");
                break;
            case 'month':
                $task->month = $dateTime->format("m");
                break;
        }

        return $task->save();
    }


    private
    function getMonthlyTasks(\DateTime $dateTime)
    {
        $monthNumber = $dateTime->format("m");

        return MonthlyTask::where('month', intval($monthNumber))
            ->orderBy('priority', 'asc')
            ->get();
    }

    private
    function getWeeklyTasks(\DateTime $dateTime)
    {
        $weekNumber = $dateTime->format("W");

        return WeeklyTask::where('week', intval($weekNumber))
            ->orderBy('priority', 'asc')
            ->get();
    }

    private
    function getTasks(\DateTime $dateTime)
    {
        return Task::whereDate('date', '=', $dateTime->format('Y-m-d'))
            ->orderBy('priority', 'asc')
            ->get();
    }

    /**
     * @param $idTask
     * @param $type
     * @return mixed
     */
    public function getTaskByType($idTask, $type)
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
     * @param $dateTimeString
     * @return \DateTime
     */
    public function getDateTimeFromString($dateTimeString)
    {
        $dateTime = \DateTime::createFromFormat('Ymd', $dateTimeString);
        return $dateTime;
    }
}
