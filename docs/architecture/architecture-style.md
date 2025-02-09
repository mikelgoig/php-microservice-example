# Architecture Style

## Microservice Backend Architecture

The **Bookshop System** is designed using a **Microservice Backend Architecture**.

This architectural style structures the application as a collection of small, autonomous services, each dedicated to a
specific business capability. Services communicate using lightweight protocols, such as:

- **HTTP/REST** for synchronous communication.
- **Messaging systems** for asynchronous communication.

### Catalog Service

This document focuses on the **Catalog Service**, which is one of the core microservices in the Bookshop System. The
service is architected using a combination of **Clean Architecture** and **Vertical Slice Architecture**. The choice
between these two approaches depends on the complexity of the module being implemented.

---

## Clean Architecture

**Clean Architecture** emphasizes separation of concerns and ensures independence between high-level policies and
low-level details. The application is structured into the following layers:

1. **Domain Layer**: The core business logic and rules.
2. **Application Layer**: Coordination of use cases and business workflows.
3. **Infrastructure Layer**: External system integrations (e.g., databases, APIs).
4. **Presentation Layer**: User interaction or interface (e.g., REST controllers).

The core business logic is designed to remain completely independent of frameworks, databases, or APIs. This
independence ensures easier testing, better maintainability, and aligns with the principles of **Domain-Driven Design**.
Additionally, it simplifies adapting the system to evolving requirements.

---

## Vertical Slice Architecture

**Vertical Slice Architecture** organizes code by feature rather than horizontal layers. Each "slice" encapsulates all
functionality related to a specific feature.

This approach removes unnecessary cross-layer dependencies, reducing cognitive complexity. It increases modularity,
allowing each feature to be updated independently without impacting others. Additionally, it enhances scalability and
extensibility for future development. It complements modern practices like **Command-Query Responsibility Segregation (
CQRS)** and aligns seamlessly with **Domain-Driven Design** principles for improved organization.
