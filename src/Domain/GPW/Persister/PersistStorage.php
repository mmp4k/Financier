<?php

namespace Domain\GPW\Persister;

use Domain\GPW\ClosingPrice;

interface PersistStorage
{
    /**
     * @param ClosingPrice $closingPrice
     */
    public function persist(ClosingPrice $closingPrice) : void;
}
