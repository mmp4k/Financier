<?php

namespace Domain\User;

use Ramsey\Uuid\UuidInterface;

interface UserResource
{
    public function id() : UuidInterface;
    public function resourceType() : string;
    public function user() : User;
}
