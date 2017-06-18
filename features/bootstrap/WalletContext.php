<?php
use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;

class WalletContext implements Context
{
    /**
     * @var \Domain\Wallet\Wallet
     */
    private $wallet;

    /**
     * @var \Domain\User\User
     */
    private $user;

    /**
     * @var \Domain\Wallet\InMemoryStorage
     */
    private $walletStorage;

    /**
     * @var \Domain\User\AssignerInMemoryStorage
     */
    private $assignerStorage;

    /**
     * @var float
     */
    private $currentSharePrice;

    /**
     * @var float
     */
    private $currentCommissionOut;

    /**
     * @BeforeScenario
     */
    public function prepare()
    {
        $this->walletStorage = new \Domain\Wallet\InMemoryStorage();
        $this->assignerStorage = new \Domain\User\AssignerInMemoryStorage();
    }

    protected function createWallet()
    {
        return new Domain\Wallet\Wallet();
    }

    protected function createTransaction($boughtAssets = 5)
    {
        return new \Domain\Wallet\WalletTransaction(
            new \Domain\Wallet\TestAsset(),
            new DateTime(), $boughtAssets, 15.0, 5.0);;
    }

    protected function assignWallet(\Domain\Wallet\Wallet $wallet)
    {
        $assigner = new \Domain\User\Assigner($this->assignerStorage);
        $assigner->assign(new \Architecture\Wallet\UserResource\UserWallet($wallet, $this->user));
    }

    protected function persistWallet(\Domain\Wallet\Wallet $wallet)
    {
        $persister = new \Domain\Wallet\Persister($this->walletStorage);
        $persister->persist($wallet);
    }

    protected function findUserWallets(\Domain\User\User $user)
    {
        $finder = new \Architecture\Wallet\UserResource\UserWalletFinder(
            new \Domain\User\UserResourceFinder($this->assignerStorage),
            new \Domain\Wallet\Fetcher($this->walletStorage)
        );

        return $finder->findWallets($user);
    }

    /**
     * @When /^Transaction is added to wallet\.$/
     */
    public function transactionIsAddedToWallet()
    {
        $transaction = $this->createTransaction();
        $this->wallet = $this->createWallet();
        $this->wallet->addTransaction($transaction);
    }

    /**
     * @Then /^Wallet should contain "([^"]*)" transaction\.$/
     */
    public function walletShouldContainTransaction(int $numOfTransactions)
    {
        assert($numOfTransactions === count($this->wallet->getTransactions()));
    }

    /**
     * @When /^Three transactions are added to wallet\.$/
     */
    public function threeTransactionsAreAddedToWallet()
    {
        $this->wallet = $this->createWallet();

        for ($i = 0; $i < 3; $i++) {
            $transaction = $this->createTransaction();
            $this->wallet->addTransaction($transaction);
        }
    }

    /**
     * @Given /^I have one wallet with three transactions\.$/
     */
    public function iHaveOneWalletWithThreeTransactions()
    {
        $this->threeTransactionsAreAddedToWallet();
        $this->persistWallet($this->wallet);
        $this->assignWallet($this->wallet);
    }

    /**
     * @Given /^I want to save wallet\.$/
     */
    public function iWantToSaveWallet()
    {

    }

    /**
     * @Then /^I should have one wallet with three transactions in database\.$/
     */
    public function iShouldHaveOneWalletWithThreeTransactionsInDatabase()
    {
        $wallets = $this->findUserWallets($this->user);
        assert(1 === count($wallets));
        assert(3 === count($wallets[0]->getTransactions()));
    }

    /**
     * @Given /^I have one wallet with two transactions\.$/
     */
    public function iHaveOneWalletWithTwoTransactions()
    {
        $this->wallet = $this->createWallet();

        for ($i = 0; $i < 2; $i++) {
            $transaction = $this->createTransaction();
            $this->wallet->addTransaction($transaction);
        }

        $this->persistWallet($this->wallet);
        $this->assignWallet($this->wallet);
    }

    /**
     * @Then /^I should have two wallets with five transactions in database\.$/
     */
    public function iShouldHaveTwoWalletsWithFiveTransactionsInDatabase()
    {
        $wallets = $this->findUserWallets($this->user);
        assert(2 === count($wallets));
        assert(3 === count($wallets[0]->getTransactions()));
        assert(2 === count($wallets[1]->getTransactions()));
    }

    /**
     * @When I am user.
     */
    public function iAmUser()
    {
        $this->user = new Domain\User\User('random@user.com');
    }

    /**
     * @Given /^I have one wallet without transactions\.$/
     */
    public function iHaveOneWalletWithoutTransactions()
    {
        $this->wallet = $this->createWallet();
        $this->persistWallet($this->wallet);
        $this->assignWallet($this->wallet);
    }

    /**
     * @Then /^I should have one wallet without transactions in database\.$/
     */
    public function iShouldHaveOneWalletWithoutTransactionsInDatabase()
    {
        $wallets = $this->findUserWallets($this->user);
        assert(1 === count($wallets));
        assert(0 === count($wallets[0]->getTransactions()));
    }

    /**
     * @When /^User have a wallet with three transactions, each transactions costs 15.0 PLN plus \+ 5.00 PLN for commission$/
     */
    public function userHaveAWalletWithThreeTransactionsEachTransactionsCostsPLNPlusPLNForCommission()
    {
        $this->wallet = $this->createWallet();

        for ($i = 0; $i < 3; $i++) {
            $transaction = $this->createTransaction(1);
            $this->wallet->addTransaction($transaction);
        }
    }

    /**
     * @Given /^Share price is (\d.+) PLN$/
     */
    public function sharePriceIsPLN(float $sharePrice)
    {
        $this->currentSharePrice = $sharePrice;
    }

    /**
     * @Given /^Commission out is (\d.+) PLN$/
     */
    public function commissionOutIsPLN(float $commissionOut)
    {
        $this->currentCommissionOut = $commissionOut;
    }

    /**
     * @Then /^Value of investments is ([\-\.\d]+) PLN$/
     */
    public function valueOfInvestmentsIsPLN(float $expectedValue)
    {
        $currentValue = $this->wallet->currentValue($this->currentSharePrice, $this->currentCommissionOut);

        $equalFloat = (abs(($expectedValue-$currentValue)/$currentValue) < 0.00001);
        assert($equalFloat === true, sprintf("Current value is %s, expected: %s", $currentValue, $expectedValue));;
    }

    /**
     * @Given /^My profit is ([\-\.\d]+) PLN$/
     */
    public function myProfitIsPLN(float $expectedProfit)
    {
        $currentValue = $this->wallet->moneyProfit($this->currentSharePrice, $this->currentCommissionOut);

        $equalFloat = (abs(($expectedProfit-$currentValue)/$currentValue) < 0.00001);
        assert($equalFloat === true, sprintf("Current value is %s, expected: %s", $currentValue, $expectedProfit));;
    }
}