@USER @USER-REGISTER
Feature: POST /users/register
  In order to register a User
  I need to check the response

  @USER @USER-REGISTER @REGISTER
  Scenario: Post
    When I do a "POST" to "users/register"
    """
      {
        "name": "User",
        "email": "user@email.com",
        "password": "User@01"
      }
    """
    Then I should check the Register Response


#  @USER @USER-REGISTER @REGISTER-DUPLICITY
#  Scenario: Post Duplicity
#    When I do a "POST" to "users/register"
#    """
#      {
#        "name": "User",
#        "email": "user@email.com",
#        "password": "User@01"
#      }
#    """
#    Then I should get 400