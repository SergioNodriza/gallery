@PHOTO @PHOTO-GET
Feature: GET /photos
  In order to get the Photos
  I need to check the response

  @PHOTO @PHOTO-GET-ALL
  Scenario: GET All
    When I do a "GET" to "photos"
    Then I should check the GET All Photos Response

  @USER @USER-GET-ID
  Scenario: GET All
    When I do a "GET" to "photos/41bc543a-2fff-4f05-87eb-18d229c51dbf"
    Then I should check the GET Photo By Id Response
