Feature: Get book
  In order to access detailed book information
  As a Manager
  I need to retrieve an existing book

  Scenario: [OK] The book exists
    Given I create the book AWAA
    When I get the last book created
    Then I should receive a "200" response code
    And I should receive a JSON response that contains:
      """
      {
        "@context": "/api/contexts/Book",
        "@type": "Book",
        "name": "Advanced Web Application Architecture"
      }
      """
    And I see that request matches the OpenAPI specification
    And I see that response matches the OpenAPI specification
