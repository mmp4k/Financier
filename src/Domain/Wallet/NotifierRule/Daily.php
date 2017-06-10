<?php

namespace Domain\Wallet\NotifierRule;

use Domain\Notifier\NotifierRule;
use Domain\Notifier\PersistableNotifierRule;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class Daily implements NotifierRule, PersistableNotifierRule
{
    /**
     * @var UuidInterface
     */
    private $id;

    public function __construct()
    {
        $this->id = Uuid::uuid4();
    }

    public function notify(): bool
    {
        return true;
    }

    public function persistConfig(): array
    {
        return [];
    }

    public function id(): UuidInterface
    {
        return $this->id;
    }

    public function setId(UuidInterface $id)
    {
        $this->id = $id;
    }
}
