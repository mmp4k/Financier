<?php

namespace Architecture\User\AssignerStorage;

use Doctrine\DBAL\Connection;
use Domain\User\AssignerStorage;
use Domain\User\User;
use Domain\User\UserResource;

class Doctrine implements AssignerStorage
{
    /**
     * @var Connection
     */
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function assign(UserResource $resource)
    {
        $qb = $this->connection->createQueryBuilder();

        $qb->insert('user_resource')
            ->values([
                'type' => ':type',
                'user' => ':user',
                'resource' => ':resource'
            ])
            ->setParameters([
                ':type' => $resource->resourceType(),
                ':resource' => $resource->id()->getBytes(),
                ':user' => $resource->user()->id()->getBytes()
            ])
            ->execute();
    }
}