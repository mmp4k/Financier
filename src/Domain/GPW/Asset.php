<?php

namespace Domain\GPW;

class Asset
{
    /**
     * @var string
     */
    private $code;

    /**
     * @param string $code
     */
    public function __construct(string $code)
    {
        $this->code = $code;
    }

    /**
     * @return string
     */
    public function code() : string
    {
        return $this->code;
    }
}
