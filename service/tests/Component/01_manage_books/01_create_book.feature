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
    Then I see that request matches the OpenAPI specification
    And the response code is "201"
    And the response body contains JSON:
      """
      {
        "@context": "/api/contexts/Book",
        "@type": "Book",
        "name": "Advanced Web Application Architecture"
      }
      """
    And I see that response matches the OpenAPI specification

  Scenario: [KO] The data is null
    When I send a "POST" request to "/api/books" with:
      """
      {
        "headers": {
          "Content-Type": "application/json"
        },
        "body": {}
      }
      """
    Then the response code is "422"
    And the response body contains JSON:
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
    And I see that response matches the OpenAPI specification

  Scenario: [KO] The data is blank
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
    Then the response code is "422"
    And the response body contains JSON:
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
    And I see that response matches the OpenAPI specification

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
    Then the response code is "422"
    And the response body contains JSON:
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
    And I see that response matches the OpenAPI specification

  Scenario: [KO] Already exists a book with the given name
    Given I create the book AWAA
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
    Then the response code is "409"
    And the response body contains JSON:
      """
      {
        "@context": "/api/contexts/Error",
        "@id": "/api/errors/409",
        "@type": "Error",
        "title": "An error occurred",
        "description": "Book with name <Advanced Web Application Architecture> already exists.",
        "type": "/errors/409",
        "status": 409
      }
      """
    And I see that response matches the OpenAPI specification
