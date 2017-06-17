Feature: In order to manage stock transactions
  As a system
  I would allow to add transaction to wallet.

  Scenario: Adding single transaction to wallet
    When Transaction is added to wallet.
    Then Wallet should contain "1" transaction.

  Scenario: Adding three transactions to wallet.
    When Three transactions are added to wallet.
    Then Wallet should contain "3" transaction.