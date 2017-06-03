<?php

namespace Architecture\Wallet\FetcherStorage;

use Doctrine\DBAL\Connection;
use Domain\ETFSP500\ETFSP500;
use Domain\Wallet\FetcherStorage;
use Domain\Wallet\PersisterStorage;
use Domain\Wallet\Wallet;
use Domain\Wallet\WalletTransaction;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

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

    public function findWallet(UuidInterface $uuid): Wallet
    {
        $qb = $this->connection->createQueryBuilder();

        $row = $qb->select('uuid')
            ->from('wallet')
            ->where('uuid = :uuid')
            ->setParameter(':uuid', $uuid->getBytes())
            ->execute()
            ->fetch();

        if (!$row) {
            throw new \DomainException("Wallet doesn't exist in database.");
        }

        return Wallet::createFromUuid($uuid);
    }

    /**
     * @param Wallet $wallet
     *
     * @return WalletTransaction[]
     */
    public function findTransactions(Wallet $wallet): array
    {
        $qb = $this->connection->createQueryBuilder();

        $rows = $qb->select('*')
            ->from('wallet_transaction')
            ->where('wallet_uuid = :wallet')
            ->setParameter(':wallet', $wallet->id()->getBytes())
            ->orderBy('date', 'ASC')
            ->execute()
            ->fetchAll();

        $transactions = [];

        foreach ($rows as $row) {
            $transaction = new WalletTransaction(new ETFSP500(),
                \DateTime::createFromFormat('Y-m-d', $row['date']),
                $row['bought_assets'],
                $row['price_single_asset'],
                $row['commission_in']);
            $transaction->setUuid(Uuid::fromBytes($row['uuid']));
            $transactions[] = $transaction;
            $wallet->addTransaction($transaction);
        }

        return $transactions;
    }

    /**
     * @return Wallet[]
     */
    public function findWallets(): array
    {
        $qb = $this->connection->createQueryBuilder();

        $rows = $qb->select('uuid')
            ->from('wallet')
            ->execute()
            ->fetchAll();

        $wallets = [];

        foreach ($rows as $row) {
            $wallets[] = Wallet::createFromUuid(Uuid::fromBytes($row['uuid']));
        }

        return $wallets;
    }
}