Feature: Get book
  In order to access detailed book information
  As a Manager
  I need to retrieve an existing book

  Scenario: [OK] The book exists
    Given I create the book "Advanced Web Application Architecture"
    When I get the last book created
    Then the request matches the OpenAPI specification
    And the response code is "200"
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

  Scenario: [OK] The book does not exist
    When I send a "GET" request to "/api/books/019461ba-a46e-722d-8ea4-09832f35a713"
    Then the response code is "404"
    And the response body contains JSON:
      """
      {
        "@context": "/api/contexts/Error",
        "@id": "/api/errors/404",
        "@type": "Error",
        "title": "An error occurred",
        "description": "Could not find book <019461ba-a46e-722d-8ea4-09832f35a713>."
      }
      """
    And the response matches the OpenAPI specification
