@USER @USER-PUT
Feature: PUT /users/id
  In order to update a User
  I need to check the response

  @USER @USER-PUT @PUT
  Scenario: Put User
    When I do a "PUT" to "users/113ac47c-73ff-4f51-b4b9-ccaee1e3c3d4" as "113ac47c-73ff-4f51-b4b9-ccaee1e3c3d4"
    """
      {
        "name": "EditedUser"
      }
    """
    Then I should get 200
    And I should check the PUT User Response

  @USER @USER-PUT @PUT
  Scenario: Put Another User
    When I do a "PUT" to "users/87c63d28-a358-4f7f-b456-edaa097a2c68" as "113ac47c-73ff-4f51-b4b9-ccaee1e3c3d4"
    """
      {
        "name": "EditedUser"
      }
    """
    Then I should get 403

  @USER @USER-PUT @PUT
  Scenario: Put User As Anonymous
    When I do a "PUT" to "users/113ac47c-73ff-4f51-b4b9-ccaee1e3c3d4"
    """
      {
        "name": "EditedUser"
      }
    """
    Then I should get 401