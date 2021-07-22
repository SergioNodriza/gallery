@PHOTO @PHOTO-PUT
Feature: PUT /photos/id
  In order to update a Photo
  I need to check the response

  @PHOTO @PHOTO-PUT @PUT
  Scenario: Put Photo
    When I do a "PUT" to "photos/41bc543a-2fff-4f05-87eb-18d229c51dbf" as "113ac47c-73ff-4f51-b4b9-ccaee1e3c3d4"
    """
      {
        "description": "EditedDescription",
        "private": true
      }
    """
    Then I should get 200
    And I should check the PUT Photo Response

  @PHOTO @PHOTO-PUT @PUT
  Scenario: Put Another User's Photo
    When I do a "PUT" to "photos/ed7a6086-af5e-4f0d-ad6f-2f3f39bc794a" as "113ac47c-73ff-4f51-b4b9-ccaee1e3c3d4"
    """
      {
        "description": "EditedDescription",
        "private": true
      }
    """
    Then I should get 403


  @PHOTO @PHOTO-PUT @PUT
  Scenario: Put Photo As Anonymous
    When I do a "PUT" to "photos/41bc543a-2fff-4f05-87eb-18d229c51dbf"
    """
      {
        "description": "EditedDescription",
        "private": true
      }
    """
    Then I should get 401