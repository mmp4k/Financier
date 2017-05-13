<?php

namespace App;

interface NotifierProvider
{

    /**
     * @param string[] $body
     *
     * @return mixed
     */
    public function send(array $body);
}
