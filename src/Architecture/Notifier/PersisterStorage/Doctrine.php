<?php

namespace Architecture\Notifier\PersisterStorage;

use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\DriverManager;
use Domain\Notifier\PersistableNotifierRule;
use Domain\Notifier\PersisterStorage;

class Doctrine implements PersisterStorage
{
    private $connection;

    public function __construct(array $connectionParams)
    {
        $config = new Configuration();
        $this->connection = DriverManager::getConnection($connectionParams, $config);
    }

    public function persist(PersistableNotifierRule $persistableNotifierRule)
    {
        $qb = $this->connection->createQueryBuilder();

        $qb->insert('notifier_rules')
            ->setValue('class', '?')
            ->setValue('options', '?')
            ->setParameters([
                get_class($persistableNotifierRule),
                json_encode($persistableNotifierRule->persistConfig())
            ])
            ->execute();
    }
}