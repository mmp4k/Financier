Feature: In order to count profit from investing in ETFSP500
  As a user
  I want add my assets to wallet

  Scenario: I have one assets.
    Value of ETFSP500 grows but I lose because I had only one asset and I paid 10 PLN commissions.
    Given My ETFSP500 wallet looks like
      | Date of investment | Bought assets | Value of investment | Commission in |
      | 24.04.2018         | 1             | 50.5                | 5.00          |
    When Current value ETFSP500 is "51" PLN
    And Commission out is "5.00"
    Then I have "41" PLN
    And The summary profit is "-18.81"%

  Scenario: I have two assets
    Given My ETFSP500 wallet looks like
      | Date of investment | Bought assets | Value of investment | Commission in |
      | 24.04.2018         | 5             | 100                 | 5.00          |
      | 28.04.2018         | 2             | 30                  | 5.00          |
    When Current value ETFSP500 is "51" PLN
    And Commission out is "5.00"
    Then I have "342" PLN
    And The summary profit is "263.08"%
    And The profit on first transaction is "245"%
    And the profit on second transaction is "306"%

  Scenario: I have one asset and I lose money
    Given My ETFSP500 wallet looks like
      | Date of investment | Bought assets | Value of investment | Commission in |
      | 24.04.2018         | 1             | 50                  | 5.00          |
    When Current value ETFSP500 is "25" PLN
    And Commission out is "5.00"
    Then I have "15" PLN
    And The summary profit is "-70"%

  Scenario: I have two asset, one earned, second last
    Given My ETFSP500 wallet looks like
      | Date of investment | Bought assets | Value of investment | Commission in |
      | 24.04.2018         | 1             | 50                  | 5.00          |
      | 30.04.2018         | 1             | 15                  | 5.00          |
    When Current value ETFSP500 is "25" PLN
    And Commission out is "5.00"
    Then I have "35" PLN
    And The summary profit is "-46.15"%

  Scenario: I have two asset, one earned, second last...
    Given My ETFSP500 wallet looks like
      | Date of investment | Bought assets | Value of investment | Commission in |
      | 24.04.2018         | 5             | 75                  | 5.00          |
      | 30.04.2018         | 5             | 75                  | 5.00          |
    When Current value ETFSP500 is "20" PLN
    And Commission out is "5.00"
    Then I have "185" PLN
    And The summary profit is "123.33"%