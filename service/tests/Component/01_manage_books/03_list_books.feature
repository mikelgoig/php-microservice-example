Feature: List books
  In order to efficiently manage and review book data
  As a Manager
  I need to list a collection of books

  Scenario: [OK] List all
    Given I create the book AWAA
    And I create the book DDD
    When I send a "GET" request to "/api/books"
    Then I should receive a "200" response code
    And I should receive a JSON response that contains:
      """
      {
        "@context": "/api/contexts/Book",
        "@id": "/api/books",
        "@type": "Collection",
        "totalItems": 2,
        "member": [
          {
            "@id": "/api/books/0193e440-4dd0-7ff9-b3a6-2eb050bcd635",
            "@type": "Book",
            "id": "0193e440-4dd0-7ff9-b3a6-2eb050bcd635",
            "name": "Advanced Web Application Architecture"
          },
          {
            "@id": "/api/books/0194462f-3a79-7556-a2d7-9fa7db847708",
            "@type": "Book",
            "id": "0194462f-3a79-7556-a2d7-9fa7db847708",
            "name": "Domain-Driven Design in PHP"
          }
        ]
      }
      """
