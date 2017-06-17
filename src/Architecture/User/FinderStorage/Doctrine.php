<?php

namespace Architecture\User\FinderStorage;

use Doctrine\DBAL\Connection;
use Domain\User\FinderStorage;
use Domain\User\User;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class Doctrine implements FinderStorage
{
    /**
     * @var Connection
     */
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param string $type
     *
     * @return array|UuidInterface[]
     */
    public function findByType(string $type): array
    {
        $qb = $this->connection->createQueryBuilder();

        $rows = $qb->select('*')
            ->from('user_resource')
            ->where('type = :type')
            ->setParameter(':type', $type)
            ->execute()
            ->fetchAll();

        $uuids = [];

        foreach ($rows as $row) {
            $uuids[] = Uuid::fromBytes($row['resource']);
        }

        return $uuids;
    }

    /**
     * @param string $type
     * @param User $user
     *
     * @return array|UuidInterface[]
     */
    public function findByTypeAndUser(string $type, User $user): array
    {
        $qb = $this->connection->createQueryBuilder();

        $rows = $qb->select('*')
            ->from('user_resource')
            ->where('type = :type AND user = :user')
            ->setParameter(':type', $type)
            ->setParameter(':user', $user->id()->getBytes())
            ->execute()
            ->fetchAll();

        $uuids = [];

        foreach ($rows as $row) {
            $uuids[] = Uuid::fromBytes($row['resource']);
        }

        return $uuids;
    }

    public function findByTypeAndResource(string $type, UuidInterface $idResource): User
    {
        $qb = $this->connection->createQueryBuilder();

        $row = $qb->select('user')
            ->from('user_resource')
            ->where('type = :type AND resource = :resource')
            ->setParameter(':type', $type)
            ->setParameter(':resource', $idResource->getBytes())
            ->execute()
            ->fetch();

        if (!$row) {
            return null;
        }

        $qb = $this->connection->createQueryBuilder();

        $userRow = $qb->select('identify')
            ->from('user')
            ->where('uuid = :uuid')
            ->setParameter(':uuid', $row['user'])
            ->execute()
            ->fetch();

        if (!$userRow) {
            return null;
        }

        $user = new User($userRow['identify']);
        $user->setId(Uuid::fromBytes($row['user']));

        return $user;
    }
}