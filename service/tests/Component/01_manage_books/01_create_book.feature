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
          "id": "0193e440-4dd0-7ff9-b3a6-2eb050bcd635",
          "name": "Advanced Web Application Architecture"
        }
      }
      """
    And I should receive a "201" response code
    And I should receive a JSON response that contains:
      """
      {
        "@context": "/api/contexts/Book",
        "@id": "/api/books/0193e440-4dd0-7ff9-b3a6-2eb050bcd635",
        "@type": "Book",
        "id": "0193e440-4dd0-7ff9-b3a6-2eb050bcd635"
      }
      """
