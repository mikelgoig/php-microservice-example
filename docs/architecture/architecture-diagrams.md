# Architecture Diagrams

## Level 1: System Context

```mermaid
C4Context
    title [System Context] Bookshop System
    Person(manager, "Manager", "A manager<br>of the bookshop.")
    Person(customer, "Customer", "A customer<br>of the bookshop.")
    System(bookshopSystem, "Bookshop System", "Allows customers to search<br>and buy books.")
    System_Ext(emailSystem, "E-mail System", "The internal AWS<br>e-mail system.")
    Rel(customer, bookshopSystem, "Searches and buy books<br>using")
    Rel(manager, bookshopSystem, "Manages the system<br>using")
    Rel(bookshopSystem, emailSystem, "Sends e-mails<br>using")
    Rel(emailSystem, customer, "Sends e-mails to")
    UpdateLayoutConfig($c4ShapeInRow="2", $c4BoundaryInRow="1")
```
