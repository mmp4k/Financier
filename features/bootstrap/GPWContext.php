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
     * @var \Domain\User\User
     */
    private $user;

    /**
     * @var \Domain\User\AssignerInMemoryStorage
     */
    private $assignerStorage;

    /**
     * @var \Domain\Notifier\InMemoryStorage
     */
    private $notifierStorage;


    /**
     * @BeforeScenario
     */
    public function prepare()
    {
        $this->storage = new \Domain\GPW\InMemoryStorage();
        $this->notifierStorage = new \Domain\Notifier\InMemoryStorage();
        $this->assignerStorage = new \Domain\User\AssignerInMemoryStorage();
    }

    protected function createLessThanRule(float $price)
    {
        return new \Domain\GPW\NotifierRule\LessThan(new \Domain\GPW\Asset('Random'), $price);;
    }

    protected function createNotifier(\Architecture\Notifier\NotifierProvider\ArrayProvider\Response $response)
    {
        $fetcher = new \Domain\GPW\Fetcher($this->storage);
        $notifier = new \Domain\Notifier\Notifier(new \Architecture\Notifier\NotifierProvider\ArrayProvider($response));
        $notifier->collect($this->lessThan);
        $notifier->addNotifyHandler(new \Domain\GPW\NotifyHandler\LessThan($fetcher));
        $notifier->notify();
    }

    /**
     * @When /^Share price is "([^"]*)"\.$/
     */
    public function sharePriceIs(float $price)
    {
        $closingPrice = new \Domain\GPW\ClosingPrice(new \Domain\GPW\Asset('Random'), new DateTime(), $price);

        $persister = new \Domain\GPW\Persister($this->storage);
        $persister->persist($closingPrice);
    }

    /**
     * @Given /^Notification is set to "([^"]*)"$/
     */
    public function notificationIsSetTo(float $price)
    {
        $this->lessThan = $this->createLessThanRule($price);
    }

    /**
     * @Then /^User should not receive notification\.$/
     */
    public function userShouldNotReceiveNotification()
    {
        $response = new \Architecture\Notifier\NotifierProvider\ArrayProvider\Response();
        $this->createNotifier($response);

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
        $response = new \Architecture\Notifier\NotifierProvider\ArrayProvider\Response();
        $this->createNotifier($response);

        return assert(
            count($response->getBody()) === 1,
            sprintf('Body: %s', implode("\n", $response->getBody()))
        );
    }

    /**
     * @When /^I am user\.$/
     */
    public function iAmUser()
    {
        $this->user = new \Domain\User\User('some@user.com');
    }

    /**
     * @Given /^I've created "less than" notification\.$/
     */
    public function iHaveCreatedNotification()
    {
        $lessThan = $this->createLessThanRule(15.0);

        $persister = new \Domain\Notifier\Persister($this->notifierStorage);
        $persister->persist($lessThan);

        $assigner = new \Domain\User\Assigner($this->assignerStorage);
        $assigner->assign(new \Architecture\Notifier\UserResource\UserNotifierRule($lessThan, $this->user));
    }

    /**
     * @Then /^Notification should be in persisted\.$/
     */
    public function notificationShouldBeInPersisted()
    {
        $fetcher = new \Domain\Notifier\Fetcher($this->notifierStorage);
        $fetcher->addFactory(new \Domain\GPW\NotifierRule\Factory\LessThanFactory());

        $finder = new \Architecture\Notifier\UserResource\UserNotifierFinder(
            new \Domain\User\UserResourceFinder($this->assignerStorage),
            $fetcher
        );

        $rules = $finder->findRules($this->user);
        return assert(count($rules) === 1);
    }

    /**
     * @When /^The average from last ten months is ([\d\.]+) PLN$/
     */
    public function theAverageFromLastTenMonthsIsPLN(float $average)
    {
        throw new PendingException();
    }

    /**
     * @When Share price is :sharePrice PLN
     */
    public function sharePriceIsPln(float $sharePrice)
    {
        throw new PendingException();
    }

}