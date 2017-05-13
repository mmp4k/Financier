<?php

namespace Architecture\ETFSP500\NotifyHandler;

use App\NotifierRule;
use App\NotifyHandler;

class LessThan implements NotifyHandler
{
    /**
     * @param NotifierRule|\App\ETFSP500\LessThan $notifierRule
     * @return string
     */
    public function prepareBody(NotifierRule $notifierRule)
    {
        $body = 'ETFSP500' . "\n\n";
        $body .= sprintf("Current value (%s PLN) is less than limit %s PLN.", $notifierRule->getCurrentValue(), $notifierRule->getMinValue());

        $body .= "\n\n" . 'You should sell your assets!';

        return $body;
    }

    public function isSupported(NotifierRule $notifierRule)
    {
        if (get_class($notifierRule) === \App\ETFSP500\LessThan::class) {
            return true;
        }

        return false;
    }
}
