@USER @USER-PUT
Feature: PUT /users/register
  In order to update a User
  I need to check the response

  @USER @USER-PUT @PUT
  Scenario: Post Register
    When I do a "PUT" to "users/113ac47c-73ff-4f51-b4b9-ccaee1e3c3d4" as "113ac47c-73ff-4f51-b4b9-ccaee1e3c3d4"
    """
      {
        "name": "EditedUser"
      }
    """
    Then I should get 200
    And I should check the PUT User Response