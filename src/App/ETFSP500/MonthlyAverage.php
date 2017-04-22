<?php

namespace App\ETFSP500;

class MonthlyAverage
{
    /**
     * @var int
     */
    private $month;
    /**
     * @var int
     */
    private $year;
    /**
     * @var float
     */
    private $average;

    public function __construct(int $month, int $year, float $average)
    {
        $this->month = $month;
        $this->year = $year;
        $this->average = $average;
    }

    public function month() : int
    {
        return $this->month;
    }

    public function year() : int
    {
        return $this->year;
    }

    public function average() : float
    {
        return $this->average;
    }
}
