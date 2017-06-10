<?php

namespace Domain\Notifier;

use Ramsey\Uuid\UuidInterface;

interface PersistableNotifierRule
{
    public function id() : UuidInterface;
    public function setId(UuidInterface $id);
    public function persistConfig() : array;
}
