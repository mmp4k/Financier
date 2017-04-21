<?php

namespace App;

interface NotifierRule
{
    public function notify() : bool;
}
