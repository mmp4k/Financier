<?php

namespace Domain\User;

use Ramsey\Uuid\Uuid;

class Fetcher
{
    /**
     * @var FetcherStorage
     */
    private $fetcherStorage;

    public function __construct(FetcherStorage $fetcherStorage)
    {
        $this->fetcherStorage = $fetcherStorage;
    }

    public function findUserByIdentify(string $identify) : User
    {
        $row = $this->fetcherStorage->findUserByIdentify($identify);
        $user = new User($row['identify']);
        $user->setId(Uuid::fromBytes($row['uuid']));

        return $user;
    }

    public function exists(User $user)
    {
        return $this->findUserByIdentify($user->identifier()) instanceof User ? true : false;
    }
}
