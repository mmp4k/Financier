<?php

namespace Domain\ETFSP500;

use Domain\Wallet\Asset;

class ETFSP500 implements Asset
{
    public function getName()
    {
        return 'ETFSP500';
    }
}