<?php

namespace Architecture\ETFSP500\PersisterStorage;

use Doctrine\DBAL\Connection;
use Domain\ETFSP500\DailyAverage;
use Domain\ETFSP500\MonthlyAverage;
use Architecture\ETFSP500\PersisterStorage;
use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\DriverManager;

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

    public function persistDailyAverage(DailyAverage $dailyAverage): void
    {
        $qb = $this->connection->createQueryBuilder();
        $row = $qb->select('*')
            ->from('etfsp500_daily_average', 'a')
            ->where('date = :date')
            ->setParameters([
                ':date' => $dailyAverage->date()->format('Y-m-d')
            ])
            ->execute()->fetch();

        if ($row) {
            return;
        }

        $qb = $this->connection->createQueryBuilder();

        $qb->insert('etfsp500_daily_average')
            ->setValue('date', '?')
            ->setValue('average', $dailyAverage->average())
            ->setParameter(0, $dailyAverage->date()->format('Y-m-d'))
            ->execute();

    }

}