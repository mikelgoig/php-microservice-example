Feature: List books
  In order to efficiently manage and review book data
  As a Manager
  I need to list a collection of books

  Scenario: [OK] List all
    Given I create the book AWAA
    And I create the book DDD
    When I send a "GET" request to "/api/books"
    Then the request matches the OpenAPI specification
    And the response code is "200"
    And the response body matches JSON:
      """
      {
        "@context": "/api/contexts/Book",
        "@id": "/api/books",
        "@type": "Collection",
        "totalItems": 2,
        "member": [
          {
            "@id": "/api/books/@uuid@",
            "@type": "Book",
            "name": "Domain-Driven Design in PHP"
          },
          {
            "@id": "/api/books/@uuid@",
            "@type": "Book",
            "name": "Advanced Web Application Architecture"
          }
        ]
      }
      """
    And the response matches the OpenAPI specification

  Scenario: [OK] Pagination
    Given I create the book AWAA
    And I create the book DDD
    When I send a "GET" request to "/api/books?itemsPerPage=1&page=1"
    Then the request matches the OpenAPI specification
    And the response code is "200"
    And the response body matches JSON:
      """
      {
        "@context": "/api/contexts/Book",
        "@id": "/api/books",
        "@type": "Collection",
        "totalItems": 2,
        "member": [
          {
            "@id": "/api/books/@uuid@",
            "@type": "Book",
            "name": "Domain-Driven Design in PHP"
          }
        ],
        "view": {
          "@id": "/api/books?itemsPerPage=1&page=1",
          "@type": "PartialCollectionView",
          "first": "/api/books?itemsPerPage=1&page=1",
          "last": "/api/books?itemsPerPage=1&page=2",
          "next": "/api/books?itemsPerPage=1&page=2"
        }
      }
      """
    And the response matches the OpenAPI specification
