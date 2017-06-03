<?php

namespace Domain\User;

interface FetcherStorage
{
    public function findUserByIdentify(string $identify);
}
