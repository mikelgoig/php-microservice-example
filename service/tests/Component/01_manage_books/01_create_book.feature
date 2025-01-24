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
    Then the request matches the OpenAPI specification
    And the response code is "201"
    And the response body matches JSON:
      """
      {
        "@context": "/api/contexts/Book",
        "@id": "/api/books/@uuid@",
        "@type": "Book",
        "id": "@uuid@",
        "name": "Advanced Web Application Architecture"
      }
      """
    And the response matches the OpenAPI specification

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
        "violations": [
          {
            "propertyPath": "name",
            "message": "This value should not be null."
          }
        ]
      }
      """
    And the response matches the OpenAPI specification

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
        "violations": [
          {
            "propertyPath": "name",
            "message": "This value is too short. It should have 1 character or more."
          }
        ]
      }
      """
    And the response matches the OpenAPI specification

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
        "violations": [
          {
            "propertyPath": "name",
            "message": "This value is too long. It should have 255 characters or less."
          }
        ]
      }
      """
    And the response matches the OpenAPI specification

  Scenario: [KO] A book with the given name already exists
    Given I create the book "Advanced Web Application Architecture"
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
    And the response matches the OpenAPI specification
