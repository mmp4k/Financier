<?php

namespace Domain\Wallet;

class Persister
{
    /**
     * @var PersisterStorage
     */
    private $persisterStorage;

    public function __construct(PersisterStorage $persisterStorage)
    {
        $this->persisterStorage = $persisterStorage;
    }

    public function persist(Wallet $wallet)
    {
        $id = $this->persisterStorage->persist($wallet);

        foreach ($wallet->getTransactions() as $transaction) {
            $this->persisterStorage->persistTransaction($wallet, $transaction);
        }

        return $id;
    }
}
