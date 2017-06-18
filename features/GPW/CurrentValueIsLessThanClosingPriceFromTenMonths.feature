Feature: In order to notify when closing price is less than average values from end of ten months
  As a user
  I want receive notification

  Scenario: Share price is equal to to average from last ten months. User doesn't receive notification.
    When The average from last ten months is 50.00 PLN
    And Share price is 50.00 PLN
    Then User should not receive notification.

  Scenario: Share price is higher than average from last ten months. User doesn't receive notification.
    When The average from last ten months is 49.99 PLN
    And Share price is 50.00 PLN
    Then User should not receive notification.

  Scenario: Share price is less than average from last ten months. User receives notification.
    When The average from last ten months is 50.01 PLN
    And Share price is 50.00 PLN
    Then User should receive notification.