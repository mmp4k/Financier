<?php

namespace Domain\User;

class User
{
    /**
     * @var string
     */
    private $identify;

    public function __construct(string $identify)
    {
        $this->identify = $identify;
    }

    public function identifier()
    {
        return $this->identify;
    }
}
