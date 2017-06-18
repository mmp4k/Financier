Feature: In order to count revenues of investments
  As a user
  I want know how much money I lose or I earn

  Scenario: User earns
    When User have a wallet with three transactions, each transactions costs 15.0 PLN plus + 5.00 PLN for commission
    And Share price is 50.00 PLN
    And Commission out is 5.00 PLN
    Then Value of investments is 130.00 PLN
    And My profit is 85.00 PLN

  Scenario: User loses because share price is lower than purchase price
    When User have a wallet with three transactions, each transactions costs 15.0 PLN plus + 5.00 PLN for commission
    And Share price is 10.00 PLN
    And Commission out is 5.00 PLN
    Then Value of investments is 10.00 PLN
    Then My profit is -35.00 PLN

  Scenario: User loses because share price is equal to purchase price, but commission makes different.
    When User have a wallet with three transactions, each transactions costs 15.0 PLN plus + 5.00 PLN for commission
    And Share price is 15.00 PLN
    And Commission out is 5.00 PLN
    Then Value of investments is 25.00 PLN
    Then My profit is -20.00 PLN
