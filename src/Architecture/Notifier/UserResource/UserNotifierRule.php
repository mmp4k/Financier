<?php

namespace Architecture\Notifier\UserResource;

use Domain\Notifier\NotifierRule;
use Domain\User\User;
use Domain\User\UserResource;
use Ramsey\Uuid\UuidInterface;

class UserNotifierRule implements UserResource
{
    /**
     * @var NotifierRule
     */
    private $rule;

    /**
     * @var User
     */
    private $user;

    public function __construct(NotifierRule $rule, User $user)
    {
        $this->rule = $rule;
        $this->user = $user;
    }

    public function id(): UuidInterface
    {
        return $this->rule->id();
    }

    public function resourceType(): string
    {
        return get_class($this);
    }

    public function user(): User
    {
        return $this->user;
    }

    public function getType() : string
    {
        return get_class($this->rule);
    }

    public function rule()
    {
        return $this->rule;
    }
}
