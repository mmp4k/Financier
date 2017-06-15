<?php

namespace Domain\GPW;

use Domain\GPW\Persister\PersistStorage;

class Persister
{
    /**
     * @var PersistStorage
     */
    private $storage;

    /**
     * @param PersistStorage $storage
     */
    public function __construct(PersistStorage $storage)
    {
        $this->storage = $storage;
    }

    /**
     * @param ClosingPrice $closingPrice
     */
    public function persist(ClosingPrice $closingPrice) : void
    {
        $this->storage->persist($closingPrice);
    }
}
