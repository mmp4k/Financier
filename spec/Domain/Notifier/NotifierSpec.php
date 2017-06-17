<?php

namespace spec\Domain\Notifier;

use Domain\Notifier\Notifier;
use Domain\Notifier\NotifierProvider;
use Domain\Notifier\NotifierRule;
use Domain\Notifier\NotifyHandler;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class NotifierSpec extends ObjectBehavior
{
    function let(NotifierProvider $notifierProvider)
    {
        $this->beConstructedWith($notifierProvider);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Notifier::class);
    }

    function it_collects_rules(NotifierRule $notifierRule)
    {
        $this->collect($notifierRule);
    }

    function it_collect_notifier_handlers(NotifyHandler $notifyHandler)
    {
        $this->addNotifyHandler($notifyHandler);
    }

    function it_execute_handler_when_send_notify(NotifierRule $notifierRule, NotifyHandler $notifyHandler)
    {
        $notifyHandler->support($notifierRule)->willReturn(true);
        $notifyHandler->support($notifierRule)->shouldBeCalled();
        $notifyHandler->notify($notifierRule)->willReturn(true);
        $notifyHandler->notify($notifierRule)->shouldBeCalled();
        $notifyHandler->prepareBody($notifierRule)->shouldBeCalled();

        $this->addNotifyHandler($notifyHandler);
        $this->collect($notifierRule);

        $this->notify();
    }

    function it_ignores_rule_if_is_not_supported_by_handler(NotifierRule $notifierRule, NotifyHandler $notifyHandler)
    {
        $notifyHandler->support($notifierRule)->willReturn(false);
        $notifyHandler->support($notifierRule)->shouldBeCalled();
        $notifyHandler->notify($notifierRule)->shouldNotBeCalled();
        $notifyHandler->prepareBody($notifierRule)->shouldNotBeCalled();

        $this->addNotifyHandler($notifyHandler);
        $this->collect($notifierRule);

        $this->notify();
    }
}
