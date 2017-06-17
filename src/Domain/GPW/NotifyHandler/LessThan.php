<?php

namespace Domain\GPW\NotifyHandler;

use Domain\GPW\Fetcher;
use Domain\Notifier\NotifierRule;
use Domain\Notifier\NotifyHandler;

class LessThan implements NotifyHandler
{
    /**
     * @var Fetcher
     */
    private $fetcher;

    public function __construct(Fetcher $fetcher)
    {
        $this->fetcher = $fetcher;
    }

    /**
     * @param NotifierRule|\Domain\GPW\NotifierRule\LessThan $notifierRule
     *
     * @return string
     */
    public function prepareBody(NotifierRule $notifierRule): string
    {
        $closingPrice = $this->fetcher->findTodayClosingPrice($notifierRule->asset());

        $toReturn = [];
        $toReturn[] = '--- ' . $notifierRule->asset()->code() . ' ----';
        $toReturn[] = 'Current value: ' . $closingPrice->price();
        $toReturn[] = 'Notification executed when price is less than ' . $notifierRule->minValue();

        return implode("\n", $toReturn);
    }

    public function support(NotifierRule $notifierRule): bool
    {
        return $notifierRule instanceof \Domain\GPW\NotifierRule\LessThan;
    }

    /**
     * @param NotifierRule|\Domain\GPW\NotifierRule\LessThan $notifierRule
     *
     * @return bool
     */
    public function notify(NotifierRule $notifierRule): bool
    {
        $closingPrice = $this->fetcher->findTodayClosingPrice($notifierRule->asset());

        if (!$closingPrice) {
            return false;
        }

        if ($closingPrice->price() < $notifierRule->minValue()) {
            return true;
        }

        return false;
    }
}
