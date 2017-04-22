<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;

class ETFSP500Context implements Context
{

    /**
     * @When /^Current value is "([^"]*)"$/
     */
    public function currentValueIs($arg1)
    {
        throw new PendingException();
    }

    /**
     * @Given /^Average is "([^"]*)"$/
     */
    public function averageIs($arg1)
    {
        throw new PendingException();
    }

    /**
     * @Then /^I should received notification$/
     */
    public function iShouldReceivedNotification()
    {
        throw new PendingException();
    }

    /**
     * @Then /^I should not received notification$/
     */
    public function iShouldNotReceivedNotification()
    {
        throw new PendingException();
    }

    /**
     * @Given /^Lower limit is "([^"]*)"$/
     */
    public function lowerLimitIs($arg1)
    {
        throw new PendingException();
    }
}