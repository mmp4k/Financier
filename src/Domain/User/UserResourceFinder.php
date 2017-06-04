<?php

namespace Domain\User;

use Ramsey\Uuid\UuidInterface;

class UserResourceFinder
{
    /**
     * @var FinderStorage
     */
    private $finderStorage;

    public function __construct(FinderStorage $finderStorage)
    {
        $this->finderStorage = $finderStorage;
    }

    public function findByType(string $type) : array
    {
        return $this->finderStorage->findByType($type);
    }

    /**
     * @param string $type
     * @param User $user
     *
     * @return array|UuidInterface[]
     */
    public function findByTypeAndUser(string $type, User $user) : array
    {
        return $this->finderStorage->findByTypeAndUser($type, $user);
    }

    public function findByTypeAndResource(string $type, UuidInterface $idResource) : User
    {
        return $this->finderStorage->findByTypeAndResource($type, $idResource);
    }
}
