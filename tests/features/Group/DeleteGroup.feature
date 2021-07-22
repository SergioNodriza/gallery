@GROUP @GROUP-DELETE @DELETE
Feature: DELETE /groups/id
  In order to delete to a Group
  I need to check the response

  @GROUP @GROUP-DELETE @DELETE
  Scenario: Delete Group
    When I do a "DELETE" to "groups/812ab272-dc78-4fee-a04c-d995c22dc900" as "113ac47c-73ff-4f51-b4b9-ccaee1e3c3d4"
    Then I should get 204

  @GROUP @GROUP-DELETE @DELETE
  Scenario: Delete Another User's Group
    When I do a "DELETE" to "groups/86faaa59-ebcd-4f2d-ad4c-c607d6cbf46f" as "113ac47c-73ff-4f51-b4b9-ccaee1e3c3d4"
    Then I should get 403

  @GROUP @GROUP-DELETE @DELETE
  Scenario: Delete Group As Anonymous
    When I do a "DELETE" to "groups/86faaa59-ebcd-4f2d-ad4c-c607d6cbf46f"
    Then I should get 401