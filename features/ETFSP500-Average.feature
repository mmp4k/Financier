Feature: In order to notify when current value ETFSP500 is less then average from last ten months
  As a user
  I want receive notifications

  # Integers
  Scenario: Current value is equal average
    and both numbers are integers.
    When Current value is "65"
    And Average is "65"
    Then I should received notification

  Scenario: Current value is lower than average
    and both numbers are integers.
    When Current value is "64"
    And Average is "65"
    Then I should received notification

  Scenario: Current value is greater than average
    and both numbers are integers.
    When Current value is "66"
    And Average is "65"
    Then I should not received notification

  # Fractions
  Scenario: Current value is equal average
    and both numbers are fractions.
    When Current value is "65.01"
    And Average is "65.01"
    Then I should received notification

  Scenario: Current value is lower than average
    and both numbers are fractions.
    When Current value is "65.01"
    And Average is "65.02"
    Then I should received notification

  Scenario: Current value is greater than average
    and both numbers are fractions.
    When Current value is "65.02"
    And Average is "65.01"
    Then I should not received notification

  # Current value is integer, and average is fraction.
  Scenario: Current value is lower than average
    and current value is integer, and average is fraction
    When Current value is "65"
    And Average is "65.01"
    Then I should received notification

  Scenario: Current value is greater than average
    and current value is integer, and average is fraction
    When Current value is "66"
    And Average is "65.99"
    Then I should not received notification

  # Current value is fraction, and average is fraction
  Scenario: Current value is lower than average
    and current value is fraction, and average is integer
    When Current value is "65.99"
    And Average is "66"
    Then I should received notification

  Scenario: Current value is greater than average
    and current value is fraction, and average is integer
    When Current value is "65.01"
    And Average is "65"
    Then I should not received notification