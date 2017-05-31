<?php

namespace Domain\Notifier;

interface NotifyChecker
{
    public function check(NotifierRule $rule);
}
