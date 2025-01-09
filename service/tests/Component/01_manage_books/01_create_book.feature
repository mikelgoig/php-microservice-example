Feature: Create a book
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
