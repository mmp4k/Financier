<?php

namespace Architecture\User\FetcherStorage;

use Doctrine\DBAL\Connection;
use Domain\User\FetcherStorage;

class Doctrine implements FetcherStorage
{
    /**
     * @var Connection
     */
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function findUserByIdentify(string $identify)
    {
        $qb = $this->connection->createQueryBuilder();

        $row = $qb->from('user')
            ->select('identify, uuid')
            ->where('identify = :identify')
            ->setParameter(':identify', $identify)
            ->execute()
            ->fetch();

        return $row;
    }
}