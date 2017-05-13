<?php

namespace App\ETFSP500\NotifierRule;

use App\NotifierRule;

class Daily implements NotifierRule
{
    public function notify(): bool
    {
        return true;
    }
}
