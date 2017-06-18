<?php

namespace Domain\GPW;

use Domain\GPW\Fetcher\FetchStorage;

class Fetcher
{
    /**
     * @var FetchStorage
     */
    private $source;

    /**
     * @param FetchStorage $source
     */
    public function __construct(FetchStorage $source)
    {
        $this->source = $source;
    }

    /**
     * @param ClosingPrice $closingPrice
     *
     * @return bool
     */
    public function findDuplicate(ClosingPrice $closingPrice) : bool
    {
        return $this->source->findByAssetAndDate($closingPrice->asset(), $closingPrice->date()) instanceof ClosingPrice ? true : false;
    }

    public function findTodayClosingPrice(Asset $asset) : ?ClosingPrice
    {
        return $this->source->findByAssetAndDate($asset->code(), new \DateTime());
    }

    /**
     * @param Asset $asset
     * @param \DateTime $sinceDate
     *
     * @return ClosingPrice[]
     */
    public function findClosingPricesFromEndLastTenMonths(Asset $asset, \DateTime $sinceDate)
    {
        $closingPrices = [];

        for ($i = 10; $i > 0; $i--) {
            $date = clone $sinceDate;
            $date->sub(new \DateInterval('P'.$i.'M'));
            $date->modify('last day of this month');

            $dates[] = $date;

            $businessDay = new BusinessDay($date);

            while (!$businessDay->isBusinessDay()) {
                $date->sub(new \DateInterval('P1D'));
            }

            $closingPrices[] = $this->source->findByAssetAndDate($asset->code(), $date);
        }

        return $closingPrices;
    }
}
