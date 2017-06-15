<?php

namespace Architecture\GPW\Fetcher;

use Doctrine\DBAL\Connection;
use Domain\GPW\Asset;
use Domain\GPW\ClosingPrice;
use Domain\GPW\Fetcher\FetchStorage;
use Ramsey\Uuid\Uuid;

class Doctrine implements FetchStorage
{
    /**
     * @var Connection
     */
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function findByAssetAndDate(string $assetName, \DateTime $date): ?ClosingPrice
    {
        $qb = $this->connection->createQueryBuilder();

        $row = $qb->select('*')
            ->from('gpw_closing_prices')
            ->where('asset_code = :code AND date = :date')
            ->setParameters([
                ':code' => $assetName,
                ':date' => $date->format('Y-m-d')
            ])
            ->execute()
            ->fetch();

        if (!$row) {
            return null;
        }

        $uuid = Uuid::fromBytes($row['uuid']);
        $asset = new Asset($row['asset_code']);
        $date = \DateTime::createFromFormat('Y-m-d', $row['date']);
        $price = (float)$row['closing_price'];

        return ClosingPrice::createWithUuid($uuid, $asset, $date, $price);
    }
}
