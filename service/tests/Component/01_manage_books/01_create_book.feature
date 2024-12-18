Feature: Create a book
  In order to have more books available for my clients
  As a Manager
  I need to create a new book

  Scenario: [OK] The data is valid
    When I send a "POST" request to "/api/books" with:
      """
      {
        "headers": {
            "Content-Type": "application/ld+json"
        },
        "body": {
          "name": "Advanced Web Application Architecture"
        }
      }
      """
    And I should receive a "201" response code
    And I should receive a JSON response that contains:
      """
      {
        "@context": "/api/contexts/Book",
        "@id": "/api/books/1",
        "@type": "Book",
        "id": 1,
        "name": "Advanced Web Application Architecture"
      }
      """
