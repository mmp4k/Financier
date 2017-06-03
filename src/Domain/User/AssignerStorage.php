<?php

namespace Domain\User;

interface AssignerStorage
{
    public function assign(UserResource $resource);
}
