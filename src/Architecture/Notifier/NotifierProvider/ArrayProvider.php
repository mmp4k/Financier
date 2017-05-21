<?php

namespace Architecture\Notifier\NotifierProvider;

use Architecture\Notifier\NotifierProvider\ArrayProvider\Response;
use Domain\Notifier\NotifierProvider;

class ArrayProvider implements NotifierProvider
{
    /**
     * @var Response
     */
    private $response;

    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    /**
     * @param string[] $body
     *
     * @return mixed
     */
    public function send(array $body)
    {
        $this->response->setBody($body);
        return $body;
    }
}