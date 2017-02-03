<?php
namespace App\Http\Controllers;

use App\Repository\DailyTaskRepository;
use App\Repository\MonthlyTaskRepository;
use App\Repository\TaskRepository;
use App\Repository\WeeklyTaskRepository;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    protected $repository;
    protected $monthlyTaskRepository;
    protected $weeklyTaskRepository;
    protected $dailyTaskRepository;

    public function __construct(TaskRepository $repository, DailyTaskRepository $dailyTaskRepository,
                                MonthlyTaskRepository $monthlyTaskRepository, WeeklyTaskRepository $weeklyTaskRepository)
    {
        $this->repository = $repository;
        $this->monthlyTaskRepository = $monthlyTaskRepository;
        $this->weeklyTaskRepository = $weeklyTaskRepository;
        $this->dailyTaskRepository = $dailyTaskRepository;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Request $request)
    {
        $date = $request->get('date');

        $dateTime =
            $date == '' ?
                (new \DateTime('now')) :
                ($this->getDateTimeFromString($date));

        return view('tasks',
            [
                'tasks' => $this->getDailyTaskRepository()->getDailyTasks($dateTime),
                'weeklyTasks' => $this->getWeeklyTaskRepository()->getWeeklyTasks($dateTime),
                'monthlyTasks' => $this->getMonthlyTaskRepository()->getMonthlyTasks($dateTime),
                'tomorrow' => $this->getTomorrowDate(),
                'yesterday' => $this->getYesterdayDate(),
                'today' => $this->getTodayDate(),
                'date' => $dateTime
            ]);
    }

    /**
     * @param Request $request
     * @param $type
     * @param $dateTimeString
     * @return \Illuminate\Http\RedirectResponse
     */
    public function saveTasks(Request $request, $type, $dateTimeString)
    {
        $dateTime = $this->getDateTimeFromString($dateTimeString);

        if ($request->isMethod('POST')) {
            foreach ($request->request->get('tasks') as $index => $requestTask) {
                if(empty($requestTask['name'])){
                    continue;
                }

                $requestTask['priority'] = $requestTask['priority'] ? $requestTask['priority'] : '5';
                $this->getRepository()->saveTask($requestTask, $index, $type, $dateTime);
            }

            return redirect()->route('show', ['date' => $dateTimeString]);
        }
    }

    /**
     * @param $idTask
     * @param $type
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function remove($idTask, $type)
    {
        if (!$this->getRepository()->removeTask($idTask, $type)) {
            throw new \Exception('No se pudo borrar la tarea.');
        }

        return redirect()->route('show');
    }


    /**
     * @return string
     */
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

    /**
     * @return string
     */
    private function getTodayDate()
    {
        $today = new \DateTime('now');

        return $today->format('Ymd');
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

    /**
     * @return TaskRepository
     */
    public function getRepository()
    {
        return $this->repository;
    }

    /**
     * @return MonthlyTaskRepository
     */
    public function getMonthlyTaskRepository()
    {
        return $this->monthlyTaskRepository;
    }

    /**
     * @return WeeklyTaskRepository
     */
    public function getWeeklyTaskRepository()
    {
        return $this->weeklyTaskRepository;
    }

    /**
     * @return DailyTaskRepository
     */
    public function getDailyTaskRepository()
    {
        return $this->dailyTaskRepository;
    }
}
