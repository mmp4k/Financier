<?php

namespace App\Resolver;

use Architecture\ETFSP500\Storage\Doctrine;
use Domain\ETFSP500\BusinessDay;

class TransactionTypeResolver
{
    /**
     * @var Doctrine
     */
    private $etfsp500;

    public function __construct(Doctrine $etfsp500)
    {
        $this->etfsp500 = $etfsp500;
    }

    public function getCurrentETFSP500Value() : float
    {
        $businessDay = new BusinessDay(new \DateTime());
        return $this->etfsp500->getCurrentValue($businessDay);
    }
}