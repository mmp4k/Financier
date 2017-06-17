<?php

namespace Domain\Notifier;

class Notifier
{
    /**
     * @var array|NotifierRule[]
     */
    protected $notifiers = [];

    /**
     * @var NotifierProvider
     */
    private $notifierProvider;

    /**
     * @var NotifyHandler[]
     */
    private $notifyHandlers = [];

    public function __construct(NotifierProvider $notifierProvider)
    {
        $this->notifierProvider = $notifierProvider;
    }

    public function collect(NotifierRule $notifierRule)
    {
        $this->notifiers[] = $notifierRule;
    }

    public function notify()
    {
        $body = [];

        foreach ($this->notifyHandlers as $notifyHandler) {
            foreach ($this->notifiers as $notifier) {
                if (!$notifyHandler->support($notifier)) {
                    continue;
                }

                if (!$notifyHandler->notify($notifier)) {
                    continue;
                }

                $body[] = $notifyHandler->prepareBody($notifier);
            }
        }

        if (!$body) {
            return;
        }

        $this->notifierProvider->send($body);
    }

    public function addNotifyHandler(NotifyHandler $notifyHandler)
    {
        $this->notifyHandlers[] = $notifyHandler;
    }
}
