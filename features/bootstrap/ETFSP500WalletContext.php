<?php

use Behat\Behat\Tester\Exception\PendingException;

class ETFSP500WalletContext implements \Behat\Behat\Context\Context
{
    /**
     * @var \App\ETFSP500\Wallet
     */
    private $wallet;

    /**
     * @var float
     */
    private $commissionOut;

    /**
     * @var float
     */
    private $currentValue;

    /**
     * @Given /^My ETFSP500 wallet looks like$/
     */
    public function myETFSP500walletLooksLike(\Behat\Gherkin\Node\TableNode $table)
    {
        $this->wallet = new \App\ETFSP500\Wallet();

        foreach ($table->getHash() as $row) {
            $date = DateTime::createFromFormat('d.m.Y', $row['Date of investment']);
            $boughtAssets = (int) $row['Bought assets'];
            $singlePrice = (float)$row['Value of investment'] / $boughtAssets;
            $commissionIn = (float) $row['Commission in'];


            $transaction = new \App\ETFSP500\WalletTransaction($date, $boughtAssets, $singlePrice, $commissionIn);
            $this->wallet->addTransaction($transaction);
        }
    }

    /**
     * @When /^Current value ETFSP500 is "([^"]*)" PLN$/
     */
    public function currentValueETFSP500isPLN($currentValue)
    {
        $this->currentValue = $currentValue;
    }

    /**
     * @Then /^I have "([^"]*)" PLN$/
     */
    public function iHavePLN($value)
    {
        $currentValue = $this->wallet->currentValue($this->currentValue, $this->commissionOut);
        assert((float) $value === $currentValue, sprintf('Should be "%s", was "%s"', $value, $currentValue));
    }

    /**
     * @Given /^The summary profit is "([^"]*)"%$/
     */
    public function theSummaryProfitIs(float $profit)
    {
        $currentProfit = number_format($this->wallet->profit($this->currentValue, $this->commissionOut), 4);

        if (1 >= $currentProfit) {
            $currentProfit = (1-$currentProfit)*-1;
        }
        $currentProfit = ($currentProfit)*100;

        $profit = (int)($profit*1000);
        $currentProfit = (int)($currentProfit*1000);

        assert($profit === $currentProfit, sprintf('Should be "%s", was "%s"', $profit, $currentProfit));
    }

    /**
     * @Given /^The profit on first transaction is "([^"]*)"%$/
     */
    public function theProfitOnFirstTransactionIs($arg1)
    {
        throw new PendingException();
    }

    /**
     * @Given /^the profit on second transaction is "([^"]*)"%$/
     */
    public function theProfitOnSecondTransactionIs($arg1)
    {
        throw new PendingException();
    }

    /**
     * @Given /^Commission out is "([^"]*)"$/
     */
    public function commissionOutIs($commissionOut)
    {
        $this->commissionOut = $commissionOut;
    }
}