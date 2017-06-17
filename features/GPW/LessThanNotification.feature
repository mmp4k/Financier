Feature: In order to notify when share price of asset is less than defined value
  As a user
  I want to receive notification

  Scenario: Share price is equal to defined value. User doesn't receive notification.
    When Share price is "50.12".
    And Notification is set to "50.12"
    Then User should not receive notification.

  Scenario: Share price is greater than defined value. User doesn't receive notification.
    When Share price is "50.12".
    And Notification is set to "50.11"
    Then User should not receive notification.

  Scenario: Share price is less than defined value. User receives notification.
    When Share price is "50.12".
    And Notification is set to "50.13"
    Then User should receive notification.