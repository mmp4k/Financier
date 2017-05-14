<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;

class ETFSP500Context implements Context
{
    /**
     * @var \Domain\ETFSP500\Storage\TestStorage
     */
    private $storage;

    /**
     * @var \Domain\NotifierRule
     */
    private $notifier;

    public function __construct()
    {
        $this->storage = new \Domain\ETFSP500\Storage\TestStorage();
    }

    /**
     * @When /^Current value is "([^"]*)"$/
     */
    public function currentValueIs($currentValue)
    {
        $this->storage->setCurrentValue($currentValue);
    }

    /**
     * @Given /^Average is "([^"]*)"$/
     */
    public function averageIs($average)
    {
        $this->storage->setAverageFromLastTenMonths($average);
        $this->notifier = new \Domain\ETFSP500\LessThanAverage($this->storage);
    }

    /**
     * @Then /^I should received notification$/
     */
    public function iShouldReceivedNotification()
    {
        $notify = $this->notifier->notify();
        assert(true === $notify, 'Notify is: ' . $notify);
    }

    /**
     * @Then /^I should not received notification$/
     */
    public function iShouldNotReceivedNotification()
    {
        $notify = $this->notifier->notify();
        assert(false === $notify, 'Notify is: ' . $notify);
    }

    /**
     * @Given /^Lower limit is "([^"]*)"$/
     */
    public function lowerLimitIs($minValue)
    {
        $this->notifier = new \Domain\ETFSP500\LessThan($this->storage, $minValue);
    }
}