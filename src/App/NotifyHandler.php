<?php

namespace App;

interface NotifyHandler
{
    public function prepareBody(NotifierRule $notifierRule);

    public function isSupported(NotifierRule $notifierRule);
}
