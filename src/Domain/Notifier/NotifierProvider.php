<?php

namespace Domain\Notifier;

interface NotifierProvider
{

    /**
     * @param string[] $body
     *
     * @return mixed
     */
    public function send(array $body);
}
