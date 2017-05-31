<?php

namespace spec\Domain\Notifier;

use Domain\Notifier\Notifier;
use Domain\Notifier\NotifierProvider;
use Domain\Notifier\NotifierRule;
use Domain\Notifier\NotifyHandler;
use Domain\Notifier\NotifyChecker;
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
        $notifierRule->notify()->willReturn(true);
        $this->collect($notifierRule);
        $this->notify();
    }

    function it_does_not_notify_if_not_rule_to_apply(NotifierRule $notifierRule, NotifierProvider $notifierProvider)
    {
        $notifierRule->notify()->willReturn(false);
        $notifierRule->notify()->shouldBeCalled();
        $notifierProvider->send([])->shouldNotBeCalled();

        $this->collect($notifierRule);

        $this->notify();
    }

    function it_notify_if_rule_to_apply(NotifierRule $notifierRule, NotifierProvider $notifierProvider)
    {
        $notifierRule->notify()->willReturn(true);
        $notifierRule->notify()->shouldBeCalled();
        $notifierProvider->send([])->shouldBeCalled();

        $this->collect($notifierRule);

        $this->notify();
    }

    function it_collect_notifier_handlers(NotifyHandler $notifyHandler)
    {
        $this->addNotifyHandler($notifyHandler);
    }

    function it_execute_handler_when_send_notify(NotifierRule $notifierRule, NotifyHandler $notifyHandler)
    {
        $notifierRule->notify()->willReturn(true);

        $notifyHandler->isSupported($notifierRule)->willReturn(true);
        $notifyHandler->isSupported($notifierRule)->shouldBeCalled();
        $notifyHandler->prepareBody($notifierRule)->shouldBeCalled();

        $this->addNotifyHandler($notifyHandler);
        $this->collect($notifierRule);

        $this->notify();
    }

    function it_collects_notify_checker(NotifyChecker $checker)
    {
        $this->addChecker($checker);
    }

    function it_executes_checked_when_send_notify(NotifierRule $rule, NotifyHandler $notifyHandler, NotifyChecker $checker)
    {
        $rule->notify()->willReturn(true);

        $checker->check($rule)->shouldBeCalled();

        $this->collect($rule);
        $this->addNotifyHandler($notifyHandler);
        $this->addChecker($checker);

        $this->notify();
    }
}
