Feature: In order to reuse user notification
  As a user
  I want persists my notification

  Scenario: Notification if shared price is less than defined value.
    When I am user.
    And I've created "less than" notification.
    Then Notification should be in persisted.