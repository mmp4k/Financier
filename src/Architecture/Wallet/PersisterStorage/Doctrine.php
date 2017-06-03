<?php

namespace Architecture\Wallet\PersisterStorage;

use Doctrine\DBAL\Connection;
use Domain\Wallet\PersisterStorage;
use Domain\Wallet\Wallet;
use Domain\Wallet\WalletTransaction;
use Ramsey\Uuid\Uuid;

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

    public function persist(Wallet $wallet)
    {
        $qb = $this->connection->createQueryBuilder();

        return $qb->insert('wallet')
            ->setValue('uuid', ':uuid')
            ->setParameter(':uuid', $wallet->id()->getBytes())
            ->execute();
    }

    public function persistTransaction(Wallet $wallet, WalletTransaction $transaction)
    {
        $qb = $this->connection->createQueryBuilder();

        return $qb->insert('wallet_transaction')
            ->values([
                'uuid' => ':uuid',
                'wallet_uuid' => ':wallet',
                'asset' => ':asset',
                'bought_assets' => ':bought_assets',
                'commission_in' => ':commission_in',
                'date' => ':date',
                'price_single_asset' => ':price_single_asset'
            ])
            ->setParameters([
                ':uuid' => $transaction->id()->getBytes(),
                ':wallet' => $wallet->id()->getBytes(),
                ':asset' => $transaction->assetName(),
                ':bought_assets' => $transaction->assets(),
                ':commission_in' => $transaction->commissionIn(),
                ':date' => $transaction->date()->format('Y-m-d'),
                ':price_single_asset' => $transaction->boughtValue()/$transaction->assets()
            ])
            ->execute();
    }
}