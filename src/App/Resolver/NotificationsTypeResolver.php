<?php

namespace App\Resolver;

use Domain\Notifier\Fetcher;
use Domain\Notifier\NotifierRule;

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
     * @return NotifierRule[]
     */
    public function getNotifications() : array
    {
        return $this->fetcher->getNotifierRules();
    }
}