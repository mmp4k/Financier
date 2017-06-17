Feature: In order to reuse wallets
  As a user
  I want to persist my wallets

  Scenario: User has one wallet and three transactions
    When I am user.
    And I have one wallet with three transactions.
    And I want to save wallet.
    Then I should have one wallet with three transactions in database.

  Scenario: User has two wallets, first with two transactions, second with three transactions
    When I am user.
    And I have one wallet with three transactions.
    And I have one wallet with two transactions.
    Then I should have two wallets with five transactions in database.

  Scenario: User has one empty wallet
    When I am user.
    And I have one wallet without transactions.
    Then I should have one wallet without transactions in database.
