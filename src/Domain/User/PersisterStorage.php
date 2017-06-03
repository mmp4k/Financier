<?php

namespace Domain\User;

interface PersisterStorage
{
    public function persist(User $user);
}
