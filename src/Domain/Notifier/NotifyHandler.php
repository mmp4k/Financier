<?php

namespace Domain\Notifier;

interface NotifyHandler
{
    public function prepareBody(NotifierRule $notifierRule);

    public function isSupported(NotifierRule $notifierRule);
}
