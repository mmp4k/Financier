<?php

namespace Domain\Notifier;

interface NotifyHandler
{
    public function prepareBody(NotifierRule $notifierRule) : string;

    public function support(NotifierRule $notifierRule) : bool;

    public function notify(NotifierRule $notifierRule) : bool;
}
