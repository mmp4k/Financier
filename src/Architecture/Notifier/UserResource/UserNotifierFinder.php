<?php

namespace Architecture\Notifier\UserResource;

use Domain\Notifier\Fetcher;
use Domain\User\User;
use Domain\User\UserResourceFinder;

class UserNotifierFinder
{
    /**
     * @var UserResourceFinder
     */
    private $finder;
    /**
     * @var Fetcher
     */
    private $fetcher;

    public function __construct(UserResourceFinder $finder, Fetcher $fetcher)
    {
        $this->finder = $finder;
        $this->fetcher = $fetcher;
    }

    /**
     * @param User $user
     *
     * @return UserNotifierRule[]
     */
    public function findRules(User $user)
    {
        $resources = $this->finder->findByTypeAndUser(UserNotifierRule::class, $user);

        $toReturn = [];

        foreach ($resources as $resource) {
            $rule = $this->fetcher->findRule($resource);
            $toReturn[] = new UserNotifierRule($rule, $user);
        }

        return $toReturn;
    }
}
