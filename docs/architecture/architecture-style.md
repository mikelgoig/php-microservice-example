# Architecture Style

## Monolithic Backend

The system adopts a **Monolithic Backend Architecture** where all functionality is contained within a single deployable
unit. Despite being monolithic, the architecture ensures clear separation of concerns by dividing the system into
**Bounded Contexts**, each representing a cohesive business capability.

Communication between these contexts is handled using **Integration Events** (asynchronous) and **REST APIs**
(synchronous). This approach allows for modular development within the monolith, supporting scalability and
maintainability.

---

## Hexagonal Architecture

The system follows a **Hexagonal Architecture (Ports and Adapters)** style to promote flexibility, testability, and
clear separation of concerns.
