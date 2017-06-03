<?php

namespace Domain\User;

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

    public function persist(User $user)
    {
        return $this->persisterStorage->persist($user);
    }
}
