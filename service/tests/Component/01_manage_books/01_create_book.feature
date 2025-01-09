Feature: Create book
  In order to have more books available for my clients
  As a Manager
  I need to create a new book

  Scenario: [OK] The data is valid
    When I send a "POST" request to "/api/books" with:
      """
      {
        "headers": {
          "Content-Type": "application/json"
        },
        "body": {
          "name": "Advanced Web Application Architecture"
        }
      }
      """
    Then I should receive a "201" response code
    And I should receive a JSON response that contains:
      """
      {
        "@context": "/api/contexts/Book",
        "@type": "Book",
        "name": "Advanced Web Application Architecture"
      }
      """

  Scenario: [KO] Some data is null
    When I send a "POST" request to "/api/books" with:
      """
      {
        "headers": {
          "Content-Type": "application/json"
        },
        "body": {}
      }
      """
    Then I should receive a "422" response code
    And I should receive a JSON response that contains:
      """
      {
        "@context": "/api/contexts/ConstraintViolationList",
        "@type": "ConstraintViolationList",
        "title": "An error occurred",
        "description": "name: This value should not be null.",
        "status": 422,
        "violations": [
          {
            "propertyPath": "name",
            "message": "This value should not be null."
          }
        ]
      }
      """

  Scenario: [KO] Some data is blank
    When I send a "POST" request to "/api/books" with:
      """
      {
        "headers": {
          "Content-Type": "application/json"
        },
        "body": {
          "name": ""
        }
      }
      """
    Then I should receive a "422" response code
    And I should receive a JSON response that contains:
      """
      {
        "@context": "/api/contexts/ConstraintViolationList",
        "@type": "ConstraintViolationList",
        "title": "An error occurred",
        "description": "name: This value is too short. It should have 1 character or more.",
        "status": 422,
        "violations": [
          {
            "propertyPath": "name",
            "message": "This value is too short. It should have 1 character or more."
          }
        ]
      }
      """

  Scenario: [KO] The name is too long
    When I send a "POST" request to "/api/books" with:
      """
      {
        "headers": {
          "Content-Type": "application/json"
        },
        "body": {
          "name": "In a world where technology and nature coexist, a young girl named Mia discovers a hidden garden filled with vibrant flowers and singing birds. Each day, she visits, learning the secrets of the plants and the stories of the creatures. This magical place becomes her sanctuary, inspiring her to protect the environment and share its beauty with others."
        }
      }
      """
    Then I should receive a "422" response code
    And I should receive a JSON response that contains:
      """
      {
        "@context": "/api/contexts/ConstraintViolationList",
        "@type": "ConstraintViolationList",
        "title": "An error occurred",
        "description": "name: This value is too long. It should have 255 characters or less.",
        "status": 422,
        "violations": [
          {
            "propertyPath": "name",
            "message": "This value is too long. It should have 255 characters or less."
          }
        ]
      }
      """
