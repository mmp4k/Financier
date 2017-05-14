<?php

namespace Domain;

interface NotifyHandler
{
    public function prepareBody(NotifierRule $notifierRule);

    public function isSupported(NotifierRule $notifierRule);
}
