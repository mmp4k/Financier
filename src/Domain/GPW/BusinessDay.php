<?php

namespace Domain\GPW;

class BusinessDay
{
    /**
     * @var \DateTime
     */
    private $dateTime;

    /**
     * @param \DateTime $dateTime
     */
    public function __construct(\DateTime $dateTime)
    {
        $this->dateTime = $dateTime;
    }

    /**
     * @return bool
     */
    public function isBusinessDay() : bool
    {
        if ($this->dateTime->format('z') == 0) {
            return false;
        }

        if ($this->dateTime->format('N') >= 6) {
            return false;
        }

        return true;
    }
}
