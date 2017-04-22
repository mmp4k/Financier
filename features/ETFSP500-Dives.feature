Feature: In order to notify when current value ETFSP500 dives
  As a user
  I want to declare lower limit
  When notify will be send.

  Scenario: Current value and limit are integers.
    When Current value is "65"
    And Lower limit is "66"
    Then I should received notification

  Scenario: Current value and limit are fraction
    When Current value is "65.08"
    And Lower limit is "65.09"
    Then I should received notification

  Scenario: Current value is integer, and limit is fraction.
    When Current value is "65"
    And Lower limit is "65.01"
    Then I should received notification

  Scenario: Current value is fraction, and limit is integer.
    When Current value is "65.99"
    And Lower limit is "66"
    Then I should received notification