<?php

namespace Domain\Notifier;

interface NotifierRule
{
    public function notify() : bool;
}
