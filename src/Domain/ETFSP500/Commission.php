<?php

namespace Domain\ETFSP500;

class Commission
{
    private $commissionIn;
    private $commissionOut;

    public function __construct(float $commissionIn, float $commissionOut)
    {
        $this->commissionIn = $commissionIn;
        $this->commissionOut = $commissionOut;
    }

    public function commissionOut() : float
    {
        return $this->commissionOut;
    }

    public function commissionIn() : float
    {
        return $this->commissionIn;
    }

    public function sumOfCommissions() : float
    {
        return $this->commissionOut() + $this->commissionIn();
    }
}
