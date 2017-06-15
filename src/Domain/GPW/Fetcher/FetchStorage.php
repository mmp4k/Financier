<?php

namespace Domain\GPW\Fetcher;

use Domain\GPW\ClosingPrice;

interface FetchStorage
{
    /**
     * @param string $assetName
     * @param \DateTime $date
     *
     * @return ClosingPrice|null
     */
    public function findByAssetAndDate(string $assetName, \DateTime $date) : ?ClosingPrice;
}
