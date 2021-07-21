@USER @USER-LOGIN
Feature: POST /users/login_check
  In order to login as a User
  I need to check the response

  @USER @USER-LOGIN @LOGIN
  Scenario: Post Login
    When I do a "POST" to "users/login_check"
    """
      {
        "username": "user@premium.com",
        "password": "password"
      }
    """
    Then I should get 200
    And I should check the Login Response

  @USER @USER-LOGIN @LOGIN-FAILED
  Scenario: Post Login
    When I do a "POST" to "users/login_check"
    """
      {
        "username": "user@premium.com",
        "password": "p"
      }
    """
    Then I should get 401