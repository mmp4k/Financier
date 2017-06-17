<?php

namespace Domain\GPW;

use Domain\GPW\Fetcher\FetchStorage;
use Domain\GPW\Persister\PersistStorage;

class InMemoryStorage implements PersistStorage, FetchStorage
{
    /**
     * @var ClosingPrice[]
     */
    private $data = [];

    /**
     * @param string $assetName
     * @param \DateTime $date
     *
     * @return ClosingPrice|null
     */
    public function findByAssetAndDate(string $assetName, \DateTime $date): ?ClosingPrice
    {
        foreach ($this->data as $closingPrice) {
            if ($closingPrice->asset() !== $assetName) {
                continue;
            }

            if ($closingPrice->date()->format('d-m-Y') !== $date->format('d-m-Y')) {
                continue;
            }

            return $closingPrice;
        }

        return null;
    }

    /**
     * @param ClosingPrice $closingPrice
     */
    public function persist(ClosingPrice $closingPrice): void
    {
        $this->data[] = $closingPrice;
    }
}