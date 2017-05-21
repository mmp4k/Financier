<?php

namespace Domain\Notifier;

class Persister
{
    /**
     * @var PersisterStorage
     */
    private $persisterStorage;

    public function __construct(PersisterStorage $persisterStorage)
    {
        $this->persisterStorage = $persisterStorage;
    }

    public function persist(PersistableNotifierRule $persistableNotifierRule)
    {
        $this->persisterStorage->persist($persistableNotifierRule);
    }
}
