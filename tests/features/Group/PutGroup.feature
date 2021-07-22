@GROUP @GROUP-PUT
Feature: PUT /groups/id
  In order to update a Group
  I need to check the response

  @GROUP @GROUP-PUT @PUT
  Scenario: Put Group
    When I do a "PUT" to "groups/812ab272-dc78-4fee-a04c-d995c22dc900" as "113ac47c-73ff-4f51-b4b9-ccaee1e3c3d4"
    """
      {
        "name": "EditedName"
      }
    """
    Then I should get 200
    And I should check the PUT Group Response

  @GROUP @GROUP-PUT @PUT
  Scenario: Put Another User's Group
    When I do a "PUT" to "groups/86faaa59-ebcd-4f2d-ad4c-c607d6cbf46f" as "113ac47c-73ff-4f51-b4b9-ccaee1e3c3d4"
    """
      {
        "name": "EditedName"
      }
    """
    Then I should get 403


  @GROUP @GROUP-PUT @PUT
  Scenario: Put Group As Anonymous
    When I do a "PUT" to "groups/812ab272-dc78-4fee-a04c-d995c22dc900"
    """
      {
        "name": "EditedName"
      }
    """
    Then I should get 401