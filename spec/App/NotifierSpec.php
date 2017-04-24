<?php

namespace spec\App;

use App\Notifier;
use App\NotifierRule;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class NotifierSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Notifier::class);
    }

    function it_collects_rules(NotifierRule $notifierRule)
    {
        $notifierRule->notify()->willReturn(true);
        $this->collect($notifierRule);
        $this->notify();
    }

    function it_notify(NotifierRule $notifierRule)
    {
        $notifierRule->notify()->shouldBeCalled();

        $this->collect($notifierRule);

        $this->notify();
    }
}
