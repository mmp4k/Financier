<?php

namespace Domain\Notifier;

interface PersisterStorage
{
    public function persist(PersistableNotifierRule $persistableNotifierRule);
}
