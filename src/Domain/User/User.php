<?php

namespace Domain\User;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class User
{
    /**
     * @var string
     */
    private $identify;

    /**
     * @var UuidInterface
     */
    private $id;

    public function __construct(string $identify)
    {
        $this->identify = $identify;
        $this->id = Uuid::uuid4();
    }

    public function identifier()
    {
        return $this->identify;
    }

    /**
     * @return UuidInterface
     */
    public function id(): UuidInterface
    {
        return $this->id;
    }
}
