@GROUP @GROUP-CREATE
Feature: PUT /groups/id
  In order to update a Group
  I need to check the response

  @GROUP @GROUP-CREATE @CREATE
  Scenario: Put Group
    When I do a "POST" to "groups" as "113ac47c-73ff-4f51-b4b9-ccaee1e3c3d4"
    """
      {
        "name": "GroupName"
      }
    """
    Then I should get 201
    And I should check the Create Group Response

  @GROUP @GROUP-CREATE @CREATE
  Scenario: Put Group As Anonymous
    When I do a "POST" to "groups"
    """
      {
        "name": "EditedName"
      }
    """
    Then I should get 401