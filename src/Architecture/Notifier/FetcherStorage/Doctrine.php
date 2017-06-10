<?php

namespace Architecture\Notifier\FetcherStorage;

use Doctrine\DBAL\Connection;
use Domain\ETFSP500\BusinessDay;
use Domain\ETFSP500\NotifierRule\Daily;
use Domain\ETFSP500\NotifierRule\LessThan;
use Domain\ETFSP500\NotifierRule\LessThanAverage;
use Domain\Notifier\FetcherStorage;
use Domain\Notifier\Storage;
use Domain\ETFSP500\Storage as ETFSP500Storage;
use Ramsey\Uuid\Uuid;

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

    public function getNotifierRules() : array
    {
        $qb = $this->connection->createQueryBuilder();

        $executedQuery = $qb->select('*')
            ->from('notifier_rules')
            ->execute();

        $rules = [];
        while($rule = $executedQuery->fetch()) {
            $options = json_decode($rule['options'], true);
            $rules[] = [
                'class' => $rule['class'],
                'options' => $options,
                'id' => Uuid::fromBytes($rule['id']),
            ];
        }

        return $rules;
    }
}
