<?php
namespace App\Http\Controllers;

use App\Repository\TaskRepository;
use Domain\Service\ValuationService;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    protected $repository;

    public function __construct(TaskRepository $repository)
    {
        $this->repository = $repository;
    }

    public function show(Request $request)
    {
        $date = $request->get('date');
        $dateTime = $date == '' ? (new \DateTime('now')) : ($this->getDateTimeFromString($date));

        $weeklyTasks = $this->getRepository()->getWeeklyTasks($dateTime);
        $monthlyTasks = $this->getRepository()->getMonthlyTasks($dateTime);
        $tasks = $this->getRepository()->getTasks($dateTime);

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

    public function saveTasks(Request $request, $type, $dateTimeString)
    {
        $dateTime = $this->getDateTimeFromString($dateTimeString);

        if ($request->isMethod('POST')) {
            foreach ($request->request->get('tasks') as $index => $requestTask) {
                if ($requestTask['priority'] == '') {
                    continue;
                }
                $this->getRepository()->saveTask($requestTask, $index, $type, $dateTime);
            }

            return redirect()->route('show', ['date' => $dateTimeString]);
        }
    }

    public function remove($idTask, $type)
    {
        if (!$this->getRepository()->removeTask($idTask, $type)) {
            throw new \Exception('No se pudo borrar la tarea.');
        }

        return redirect()->route('show');
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
}
