<?php

namespace Domain;

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
        $matched = [];

        foreach ($this->notifiers as $notifier) {
            if (!$notifier->notify()) {
                continue;
            }

            $matched[] = $notifier;
        }

        if (!$matched) {
            return;
        }

        $body = [];

        foreach ($this->notifyHandlers as $notifyHandler) {
            foreach ($matched as $notifier) {
                if (!$notifyHandler->isSupported($notifier)) {
                    continue;
                }

                $body[] = $notifyHandler->prepareBody($notifier);
            }
        }


        $this->notifierProvider->send($body);
    }

    public function addNotifyHandler(NotifyHandler $notifyHandler)
    {
        $this->notifyHandlers[] = $notifyHandler;
    }
}
