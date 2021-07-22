@PHOTO @PHOTO-INTERACT @INTERACT
Feature: POST /photos/interact
  In order to interact to a Photo
  I need to check the response

  @PHOTO @PHOTO-INTERACT @INTERACT
  Scenario: Interact Photo
    When I do a "POST" to "photos/41bc543a-2fff-4f05-87eb-18d229c51dbf/interact" as "113ac47c-73ff-4f51-b4b9-ccaee1e3c3d4"
    Then I should check the Interact Photo Response

  @PHOTO @PHOTO-INTERACT @INTERACT
  Scenario: Interact Photo As Anonymous
    When I do a "POST" to "photos/41bc543a-2fff-4f05-87eb-18d229c51dbf/interact"
    Then I should get 401