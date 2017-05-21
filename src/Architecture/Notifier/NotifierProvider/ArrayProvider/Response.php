<?php

namespace Architecture\Notifier\NotifierProvider\ArrayProvider;

class Response
{
    protected $body = [];

    /**
     * @return array
     */
    public function getBody(): array
    {
        return $this->body;
    }

    /**
     * @param array $body
     */
    public function setBody(array $body)
    {
        $this->body = $body;
    }
}