<?php

namespace Domain\ETFSP500\NotifyHandler;

use Domain\Notifier\NotifierRule;
use Domain\Notifier\NotifyHandler;

class LessThan implements NotifyHandler
{
    /**
     * @param NotifierRule|\Domain\ETFSP500\NotifierRule\LessThan $notifierRule
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
        if ($notifierRule instanceof \Domain\ETFSP500\NotifierRule\LessThan) {
            return true;
        }

        return false;
    }
}
