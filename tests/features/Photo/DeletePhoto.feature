@PHOTO @PHOTO-DELETE @DELETE
Feature: DELETE /photos/id
  In order to delete to a Photo
  I need to check the response

  @PHOTO @PHOTO-DELETE @DELETE
  Scenario: Delete Photo
    When I do a "DELETE" to "photos/4b6ed23f-8b3b-4f83-a8a4-af87b2480a92" as "113ac47c-73ff-4f51-b4b9-ccaee1e3c3d4"
    Then I should get 204

  @PHOTO @PHOTO-DELETE @DELETE
  Scenario: Delete Another User's Photo
    When I do a "DELETE" to "photos/ed7a6086-af5e-4f0d-ad6f-2f3f39bc794a" as "113ac47c-73ff-4f51-b4b9-ccaee1e3c3d4"
    Then I should get 403

  @PHOTO @PHOTO-DELETE @DELETE
  Scenario: Delete Photo As Anonymous
    When I do a "DELETE" to "photos/4b6ed23f-8b3b-4f83-a8a4-af87b2480a92"
    Then I should get 401