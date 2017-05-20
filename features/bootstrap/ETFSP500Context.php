<?php

use Behat\Behat\Context\Context;

class ETFSP500Context implements Context
{
    /**
     * @var \Domain\ETFSP500\Storage\TestStorage
     */
    private $storage;

    /**
     * @var \Domain\Notifier\NotifierRule
     */
    private $notifier;

    /**
     * @var \Domain\ETFSP500\BusinessDay
     */
    private $businessDay;

    public function __construct()
    {
        $this->storage = new \Domain\ETFSP500\Storage\TestStorage();
        $this->businessDay = new \Domain\ETFSP500\BusinessDay(\DateTime::createFromFormat('d.m.Y', '12.05.2017'));
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
        $this->notifier = new \Domain\ETFSP500\NotifierRule\LessThanAverage($this->storage, $this->businessDay);
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
        $this->notifier = new \Domain\ETFSP500\NotifierRule\LessThan($this->storage, $minValue, $this->businessDay);
    }
}