<?php

namespace Architecture\ETFSP500\Storage;

use App\ETFSP500\Storage;
use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\DriverManager;

class Doctrine implements Storage
{
    private $connection;

    public function __construct(array $connectionParams)
    {
        $config = new Configuration();
        $this->connection = DriverManager::getConnection($connectionParams, $config);
    }

    public function getCurrentValue(): float
    {
        $qb = $this->connection->createQueryBuilder();
        $row = $qb->select('*')
            ->from('etfsp500_daily_average', 'a')
            ->where('date = :date')
            ->setParameters([
                ':date' => date('Y-m-d')
            ])
            ->execute()->fetch();

        return (float) $row['average'];
    }

    public function getAverageFromLastTenMonths(): float
    {
        $qb = $this->connection->createQueryBuilder();
        $row = $qb->select('avg(average) as average')
            ->from('etfsp500_monthly_average', 'a')
            ->orderBy('year DESC, month', 'DESC')
            ->setMaxResults(10)
            ->execute()->fetch();

        return (float) $row['average'];
    }
}