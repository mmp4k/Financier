<?php

namespace Domain\ETFSP500;

class BusinessDay
{
    /**
     * @var \DateTime
     */
    private $dateTime;

    public function __construct(\DateTime $dateTime)
    {
        $this->dateTime = $dateTime;
    }

    public function isBusinessDay() : bool
    {
        if ($this->dateTime->format('N') >= 6) {
            return false;
        }

        return true;
    }
}
