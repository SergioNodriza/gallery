@GROUP @GROUP-GET
Feature: GET /groups/id
  In order to get the Group
  I need to check the response

  @GROUP @GROUP-GET-ID
  Scenario: GET Group By Id
    When I do a "GET" to "groups/812ab272-dc78-4fee-a04c-d995c22dc900" as "113ac47c-73ff-4f51-b4b9-ccaee1e3c3d4"
    Then I should check the GET Group By Id Response

  @GROUP @GROUP-GET-ID
  Scenario: GET Another User's Group By Id
    When I do a "GET" to "groups/86faaa59-ebcd-4f2d-ad4c-c607d6cbf46f" as "113ac47c-73ff-4f51-b4b9-ccaee1e3c3d4"
    Then I should get 403

  @GROUP @GROUP-GET-ID
  Scenario: GET Group By Id as Anonymous
    When I do a "GET" to "groups/812ab272-dc78-4fee-a04c-d995c22dc900"
    Then I should get 401
