<?php

namespace Domain\Wallet;

class TestAsset implements Asset
{
    public function getName()
    {
        return 'RANDOM_ASSET';
    }
}