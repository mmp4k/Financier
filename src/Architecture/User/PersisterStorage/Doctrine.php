<?php

namespace Architecture\User\PersisterStorage;

use Doctrine\DBAL\Connection;
use Domain\User\PersisterStorage;
use Domain\User\User;

class Doctrine implements PersisterStorage
{
    /**
     * @var Connection
     */
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function persist(User $user)
    {
        $qb = $this->connection->createQueryBuilder();

        $id = $qb->insert('user')
            ->values([
                'uuid' => ':uuid',
                'identify' => ':identify'
            ])
            ->setParameters([
                ':uuid' => $user->id()->getBytes(),
                ':identify' => $user->identifier(),
            ])
            ->execute();

        return $id;
    }
}