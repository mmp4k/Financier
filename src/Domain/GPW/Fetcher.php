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
}
