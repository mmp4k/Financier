<?php

namespace Domain\ETFSP500\NotifyHandler;

use Domain\Notifier\NotifierRule;
use Domain\Notifier\NotifyHandler;

class LessThanAverage implements NotifyHandler
{
    /**
     * @param NotifierRule|\Domain\ETFSP500\NotifierRule\LessThanAverage $notifierRule
     * @return string
     */
    public function prepareBody(NotifierRule $notifierRule)
    {
        $body = 'ETFSP500' . "\n\n";
        $body .= sprintf("Current value (%s PLN) is less than average from last ten months %s PLN!", $notifierRule->getCurrentValue(), $notifierRule->getAverageFromLastTenMonths());

        $body .= "\n\n" . 'You should sell your assets.';

        return $body;
    }

    public function isSupported(NotifierRule $notifierRule)
    {
        if (get_class($notifierRule) === \Domain\ETFSP500\NotifierRule\LessThanAverage::class) {
            return true;
        }

        return false;
    }
}
