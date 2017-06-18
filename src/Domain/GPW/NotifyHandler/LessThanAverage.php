<?php

namespace Domain\GPW\NotifyHandler;

use Domain\GPW\ClosingPrice;
use Domain\GPW\Fetcher;
use Domain\Notifier\NotifierRule;
use Domain\Notifier\NotifyHandler;

class LessThanAverage implements NotifyHandler
{
    /**
     * @var Fetcher
     */
    private $fetcher;

    public function __construct(Fetcher $fetcher)
    {
        $this->fetcher = $fetcher;
    }

    public function prepareBody(NotifierRule $notifierRule): string
    {

    }

    public function support(NotifierRule $notifierRule): bool
    {
        return $notifierRule instanceof \Domain\GPW\NotifierRule\LessThanAverage;
    }

    /**
     * @param NotifierRule|\Domain\GPW\NotifierRule\LessThanAverage $notifierRule
     *
     * @return bool
     */
    public function notify(NotifierRule $notifierRule): bool
    {
        $currentClosingPrice = $this->fetcher->findTodayClosingPrice($notifierRule->asset());

        if (!$currentClosingPrice) {
            return false;
        }

        $closingPrices = $this->fetcher->findClosingPricesFromEndLastTenMonths($notifierRule->asset(), new \DateTime());

        $numberOfResults = count($closingPrices);

        $sum = 0;

        foreach ($closingPrices as $closingPrice) {
            /** @var ClosingPrice $closingPrice */
            $sum += $closingPrice->price();
        }

        return $currentClosingPrice->price() < ($sum/$numberOfResults);

    }
}
