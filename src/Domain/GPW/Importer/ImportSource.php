<?php

namespace Domain\GPW\Importer;

use Domain\GPW\Asset;
use Domain\GPW\ClosingPrice;

interface ImportSource
{
    /**
     * @param Asset $asset
     *
     * @return ClosingPrice
     */
    public function importAsset(Asset $asset) : ClosingPrice;
}
