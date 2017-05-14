<?php

namespace Domain\ETFSP500;

class DailyAverage
{
    /**
     * @var \DateTime
     */
    private $date;
    /**
     * @var float
     */
    private $average;

    public function __construct(\DateTime $date, float $average)
    {
        $this->date = $date;
        $this->average = $average;
    }

    public function date() : \DateTime
    {
        return $this->date;
    }

    public function average() : float
    {
        return $this->average;
    }
}
