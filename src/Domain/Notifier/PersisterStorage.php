<?php

namespace Domain\Notifier;

interface PersisterStorage
{
    public function persist(NotifierRule $persistableNotifierRule);
}
