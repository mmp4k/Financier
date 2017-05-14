<?php

namespace Domain;

interface NotifierRule
{
    public function notify() : bool;
}
