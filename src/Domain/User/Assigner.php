<?php

namespace Domain\User;

class Assigner
{
    /**
     * @var AssignerStorage
     */
    private $storage;

    public function __construct(AssignerStorage $storage)
    {
        $this->storage = $storage;
    }

    public function assign(UserResource $resource)
    {
        $this->storage->assign($resource);
    }
}
