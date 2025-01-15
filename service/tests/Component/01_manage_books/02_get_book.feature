Feature: Get book
  In order to access detailed book information
  As a Manager
  I need to retrieve an existing book

  Scenario: [OK] The book exists
    Given I create the book AWAA
    When I get the last book created
    Then the response code is "200"
    And the response body contains JSON:
      """
      {
        "@context": "/api/contexts/Book",
        "@type": "Book",
        "name": "Advanced Web Application Architecture"
      }
      """
    And I see that request matches the OpenAPI specification
    And I see that response matches the OpenAPI specification

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
        "description": "Could not find book <019461ba-a46e-722d-8ea4-09832f35a713>.",
        "type": "/errors/404",
        "status": 404
      }
      """
    And I see that request matches the OpenAPI specification
    And I see that response matches the OpenAPI specification
