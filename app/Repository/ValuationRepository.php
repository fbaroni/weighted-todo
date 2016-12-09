<?php
namespace App\Repository;

use App\Model\MonthlyValuation;
use Domain\Service\ValuationService;

class ValuationRepository
{
    protected $valuationService;

    /**
     * TaskRepository constructor.
     * @param ValuationService $valuationService
     */
    public function __construct(ValuationService $valuationService)
    {
        $this->valuationService = $valuationService;
    }

    /**
     * @param $monthNumber
     * @param $yearNumber
     * @return MonthlyValuation
     */
    public function getMonthlyValuation($monthNumber, $yearNumber)
    {
        $monthValuation = MonthlyValuation::where('month', intval($monthNumber))
            ->where('year', intval($yearNumber))
            ->first();

        if (!$monthValuation) {
            $monthValuation = new MonthlyValuation();
            $monthValuation->month = $monthNumber;
            $monthValuation->year = $yearNumber;
        }

        return $monthValuation;
    }

    public function calculateMonthValuation(\DateTime $dateTime, $tasksMonth)
    {
        $monthNumber = intval($dateTime->format("m"));
        $yearNumber = intval($dateTime->format("Y"));

        $monthlyValuation = $this->getMonthlyValuation($monthNumber, $yearNumber);

        $monthlyValuation->valuation = $this->getValuationService()->getValuation($tasksMonth);

        $monthlyValuation->save();

        return $monthlyValuation->valuation;
    }

    /**
     * @return ValuationService
     */
    public function getValuationService()
    {
        return $this->valuationService;
    }

}