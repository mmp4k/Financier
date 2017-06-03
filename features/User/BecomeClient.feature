Feature: BecomeClient

  In order to allows people to using portal
  As Owner
  I would like to add options to register Users as Clients.

  Scenario: Unique identifier is email
    Given I have email "random@email.pl"
    And My password is "test"
    When I become client
    Then I am client

  Scenario: Unique identifier is email and client with this email exists
    Given I create second account with email "random@email.pl"
    When I become client
    Then I am not client

  Scenario: Unique identifier is mobile app session
    Given I received mobile identifier "random-string"
    When I become client
    Then I am client