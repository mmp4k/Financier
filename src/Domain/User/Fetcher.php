<?php

namespace Domain\User;

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

        return $user;
    }

    public function exists(User $user)
    {
        return $this->findUserByIdentify($user->identifier()) instanceof User ? true : false;
    }
}
