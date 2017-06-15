<?php

namespace Domain\GPW;

use Domain\GPW\Importer\ImportSource;

class Importer
{
    /**
     * @var ImportSource
     */
    private $source;

    /**
     * @var Persister
     */
    private $persister;

    /**
     * @param ImportSource $source
     * @param Persister $persister
     */
    public function __construct(ImportSource $source, Persister $persister)
    {
        $this->source = $source;
        $this->persister = $persister;
    }

    /**
     * @param Asset $asset
     *
     * @return ClosingPrice
     */
    public function importAsset(Asset $asset) : ClosingPrice
    {
        $closingPrice = $this->source->importAsset($asset);
        $this->persister->persist($closingPrice);

        return $closingPrice;
    }
}
