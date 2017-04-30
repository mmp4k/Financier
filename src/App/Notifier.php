<?php

namespace App;

class Notifier
{
    /**
     * @var array|NotifierRule[]
     */
    protected $notifiers = [];

    public function collect(NotifierRule $notifierRule)
    {
        $this->notifiers[] = $notifierRule;
    }

    public function notify()
    {
        foreach ($this->notifiers as $notifier) {
            if (!$notifier->notify()) {
                continue;
            }
        }
    }
}
