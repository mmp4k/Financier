<?php

namespace Architecture\Notifier\PersisterStorage;

use Doctrine\DBAL\Driver\Connection;
use Domain\Notifier\PersistableNotifierRule;
use Domain\Notifier\PersisterStorage;

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

    public function persist(PersistableNotifierRule $persistableNotifierRule)
    {
        $qb = $this->connection->createQueryBuilder();

        $qb->insert('notifier_rules')
            ->setValue('class', '?')
            ->setValue('options', '?')
            ->setValue('id', '?')
            ->setParameters([
                get_class($persistableNotifierRule),
                json_encode($persistableNotifierRule->persistConfig()),
                $persistableNotifierRule->id()->getBytes(),
            ])
            ->execute();
    }
}