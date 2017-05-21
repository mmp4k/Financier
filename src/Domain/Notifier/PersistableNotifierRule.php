<?php

namespace Domain\Notifier;

interface PersistableNotifierRule
{
    public function persistConfig() : array;
}
