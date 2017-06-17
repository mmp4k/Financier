<?php
use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;

class GPWContext implements Context
{
    /**
     * @var \Domain\GPW\NotifierRule\LessThan
     */
    private $lessThan;

    /**
     * @var \Domain\GPW\InMemoryStorage
     */
    private $storage;

    /**
     * @When /^Share price is "([^"]*)"\.$/
     */
    public function sharePriceIs(float $price)
    {
        $closingPrice = new \Domain\GPW\ClosingPrice(new \Domain\GPW\Asset('Random'), new DateTime(), $price);
        $this->storage = new \Domain\GPW\InMemoryStorage();
        $persister = new \Domain\GPW\Persister($this->storage);
        $persister->persist($closingPrice);
    }

    /**
     * @Given /^Notification is set to "([^"]*)"$/
     */
    public function notificationIsSetTo(float $price)
    {
        $this->lessThan = new \Domain\GPW\NotifierRule\LessThan(new \Domain\GPW\Asset('Random'), $price);
    }

    /**
     * @Then /^User should not receive notification\.$/
     */
    public function userShouldNotReceiveNotification()
    {
        $fetcher = new \Domain\GPW\Fetcher($this->storage);
        $response = new \Architecture\Notifier\NotifierProvider\ArrayProvider\Response();
        $notifier = new \Domain\Notifier\Notifier(new \Architecture\Notifier\NotifierProvider\ArrayProvider($response));
        $notifier->collect($this->lessThan);
        $notifier->addNotifyHandler(new \Domain\GPW\NotifyHandler\LessThan($fetcher));
        $notifier->notify();

        return assert(
            count($response->getBody()) === 0,
            sprintf('Body: %s', implode("\n", $response->getBody()))
            );
    }

    /**
     * @Then /^User should receive notification\.$/
     */
    public function userShouldReceiveNotification()
    {
        $fetcher = new \Domain\GPW\Fetcher($this->storage);
        $response = new \Architecture\Notifier\NotifierProvider\ArrayProvider\Response();
        $notifier = new \Domain\Notifier\Notifier(new \Architecture\Notifier\NotifierProvider\ArrayProvider($response));
        $notifier->collect($this->lessThan);
        $notifier->addNotifyHandler(new \Domain\GPW\NotifyHandler\LessThan($fetcher));
        $notifier->notify();

        return assert(
            count($response->getBody()) === 1,
            sprintf('Body: %s', implode("\n", $response->getBody()))
        );
    }
}