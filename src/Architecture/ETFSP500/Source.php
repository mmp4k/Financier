<?php

namespace Architecture\ETFSP500;

interface Source
{
    public function monthlyAverageFromBeginning() : string;

    public function dailyAverageFromBeginning() : string;
}