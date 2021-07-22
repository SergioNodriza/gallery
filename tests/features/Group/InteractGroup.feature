@GROUP @GROUP-INTERACT @INTERACT
Feature: POST /groups/id/photo
  In order to interact to a Group
  I need to check the response

  @GROUP @GROUP-INTERACT @INTERACT
  Scenario: Interact Group
    When I do a "POST" to "groups/812ab272-dc78-4fee-a04c-d995c22dc900/photo" as "113ac47c-73ff-4f51-b4b9-ccaee1e3c3d4"
    """
      {
        "photo": "/api/photos/41bc543a-2fff-4f05-87eb-18d229c51dbf"
      }
    """
    Then I should check the Interact Group Response

  @GROUP @GROUP-INTERACT @INTERACT
  Scenario: Interact Another User's Group
    When I do a "POST" to "groups/86faaa59-ebcd-4f2d-ad4c-c607d6cbf46f/photo" as "113ac47c-73ff-4f51-b4b9-ccaee1e3c3d4"
    """
      {
        "photo": "/api/photos/4b6ed23f-8b3b-4f83-a8a4-af87b2480a92"
      }
    """
    Then I should get 403

  @GROUP @GROUP-INTERACT @INTERACT
  Scenario: Interact Group As Anonymous
    When I do a "POST" to "groups/812ab272-dc78-4fee-a04c-d995c22dc900/photo"
    Then I should get 401