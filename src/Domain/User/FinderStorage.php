<?php

namespace Domain\User;

use Ramsey\Uuid\UuidInterface;

interface FinderStorage
{
    /**
     * @param string $type
     *
     * @return array|UuidInterface[]
     */
    public function findByType(string $type) : array;

    /**
     * @param string $type
     * @param User $user
     *
     * @return array|UuidInterface[]
     */
    public function findByTypeAndUser(string $type, User $user) : array;

    public function findByTypeAndResource(string $type, UuidInterface $idResource) : User;
}
