<?php

namespace Architecture\GPW\Persister;

use Doctrine\DBAL\Connection;
use Domain\GPW\ClosingPrice;
use Domain\GPW\Fetcher;
use Domain\GPW\Persister\PersistStorage;

class Doctrine implements PersistStorage
{
    /**
     * @var Connection
     */
    private $connection;
    /**
     * @var Fetcher
     */
    private $fetcher;

    public function __construct(Connection $connection, Fetcher $fetcher)
    {
        $this->connection = $connection;
        $this->fetcher = $fetcher;
    }

    /**
     * @param ClosingPrice $closingPrice
     */
    public function persist(ClosingPrice $closingPrice): void
    {
        $duplicate = $this->fetcher->findDuplicate($closingPrice);

        if ($duplicate) {
            return;
        }

        $qb = $this->connection->createQueryBuilder();

        $qb->insert('gpw_closing_prices')
            ->values([
                'uuid' => ':uuid',
                'asset_code' => ':asset',
                'closing_price' => ':price',
                'date' => ':date',
            ])
            ->setParameters([
                ':uuid' => $closingPrice->uuid()->getBytes(),
                ':asset' => $closingPrice->asset(),
                ':price' => $closingPrice->price(),
                ':date' => $closingPrice->date()->format('Y-m-d')
            ])
            ->execute();
    }
}
