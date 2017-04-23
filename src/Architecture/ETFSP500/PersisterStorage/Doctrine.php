<?php

namespace Architecture\ETFSP500\PersisterStorage;

use App\ETFSP500\MonthlyAverage;
use Architecture\ETFSP500\PersisterStorage;
use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\DriverManager;

class Doctrine implements PersisterStorage
{
    private $connection;

    public function __construct(array $connectionParams)
    {
        $config = new Configuration();
        $this->connection = DriverManager::getConnection($connectionParams, $config);
    }

    public function persistMonthlyAverage(MonthlyAverage $monthlyAverage): void
    {
        $qb = $this->connection->createQueryBuilder();
        $row = $qb->select('*')
            ->from('etfsp500_monthly_average', 'a')
            ->where('year = :year')
            ->andWhere('month = :month')
            ->setParameters([
                ':year' => $monthlyAverage->year(),
                ':month' => $monthlyAverage->month()
            ])
            ->execute()->fetch();

        if ($row) {
            return;
        }


        $qb = $this->connection->createQueryBuilder();

        $qb->insert('etfsp500_monthly_average')
            ->setValue('year', $monthlyAverage->year())
            ->setValue('month', $monthlyAverage->month())
            ->setValue('average', $monthlyAverage->average())
            ->execute();

    }
}