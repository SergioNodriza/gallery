@USER @USER-GET
Feature: GET /users
  In order to get the Users
  I need to check the response

  @USER @USER-GET-ALL
  Scenario: GET All
    When I do a "GET" to "users"
    Then I should check the GET All Users Response

  @USER @USER-GET-ID
  Scenario: GET All
    When I do a "GET" to "users/113ac47c-73ff-4f51-b4b9-ccaee1e3c3d4"
    Then I should check the GET User By Id Response
