<?php

namespace App\Resolver;

use Domain\Notifier\Fetcher;
use Domain\Notifier\NotifierRule;
use Domain\Notifier\PersistableNotifierRule;

class NotificationsTypeResolver
{
    /**
     * @var Fetcher
     */
    private $fetcher;

    public function __construct(Fetcher $fetcher)
    {
        $this->fetcher = $fetcher;
    }

    /**
     * @return NotifierRule[]|PersistableNotifierRule[]
     */
    public function getNotifications() : array
    {
        return $this->fetcher->getNotifierRules();
    }
}