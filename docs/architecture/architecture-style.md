# Architecture Style

## Microservice Backend Architecture

The system adopts a **Microservice Backend Architecture**, that structures an application as a collection of small and
autonomous services, each responsible for a specific business capability. These services communicate over lightweight
protocols, like HTTP/REST (synchronous) and messaging systems (asynchronous).

### Key Principles

1. Decoupled Services:
    - Each microservice is developed, deployed, and scaled independently.
    - Changes to one service do not require changes to others.
2. Business-Centric Design:
    - Services are organized around business capabilities rather than technical layers.
    - For example, in our Bookshop System, services might include Catalog, Orders, Payments, and Shipping.
3. Autonomy:
    - Each service has its own database or data store, ensuring complete independence and data encapsulation.
    - This avoids the challenges of shared databases across services.
4. Polyglot Technology:
    - Teams can choose the best language, framework, or tool for each service, depending on the requirements.
5. Resilience:
    - Failure in one service does not necessarily bring down the entire system.
    - Circuit breakers and retries ensure graceful degradation.
6. Lightweight Communication:
    - Communication between services uses lightweight protocols such as RESTful APIs and asynchronous messaging systems
      like Kafka or RabbitMQ.

### Core Components

1. Service Discovery:
    - Enables services to find each other dynamically.
    - Example: Eureka, Consul.
2. API Gateway:
    - Acts as a single entry point for clients, routing requests to appropriate services.
    - Handles cross-cutting concerns like authentication, logging, and rate limiting.
    - Example: Kong, AWS API Gateway, NGINX.
3. Messaging System:
    - Facilitates asynchronous communication between services.
    - Example: Kafka, RabbitMQ, Amazon SQS.
4. Observability:
    - Tools for monitoring, logging, and tracing to understand system health.
    - Example: Prometheus, Grafana, ELK Stack, Jaeger.
5. Data Management:
    - Each service owns its data, often using different databases (e.g., relational, NoSQL).

### Best Practices

1. Design for Failure:
    - Use circuit breakers, retries, and fallback mechanisms.
    - Handle partial failures gracefully.
2. Versioning APIs:
    - Ensure backward compatibility with API versioning.
3. Centralized Observability:
    - Implement centralized logging, metrics, and distributed tracing.
4. Secure Communication:
    - Use mutual TLS (mTLS) and IAM for secure inter-service communication.
5. Automate Everything:
    - Leverage CI/CD pipelines for automated testing, deployment, and rollback.
6. Domain-Driven Design (DDD):
    - Use DDD to define bounded contexts and align them with microservices.

### Challenges

1. Complexity:
    - Managing multiple services, their interactions, and deployments adds operational complexity.
2. Distributed Data Management:
    - Ensuring consistency and synchronization between services can be challenging, especially without a shared
      database.
3. Latency:
    - Network communication between services may introduce latency.
4. Monitoring and Debugging:
    - Debugging issues across distributed services requires robust monitoring, logging, and tracing tools.
5. Operational Overhead:
    - Each service requires its own CI/CD pipeline, deployment strategy, and resource provisioning.

---

## Hexagonal Architecture (Ports and Adapters)

The system follows a **Hexagonal Architecture (Ports and Adapters)** style to promote flexibility, testability, and
clear separation of concerns.

### Key Principles

1. Independence of Frameworks:
    - The architecture avoids being tightly coupled to specific frameworks or tools, allowing flexibility.
2. Testability:
    - The core business logic can be tested independently of infrastructure concerns.
3. Ease of Change:
    - External systems (e.g., switching databases or APIs) can be swapped without affecting core logic.
4. Domain-Centric Design:
    - The domain layer is at the heart of the architecture and dictates the system’s behavior.

### Core Components

1. Core Domain Logic:
    - The central hexagon represents the business rules and domain logic, independent of external systems.
    - This is where the application’s true value lies.
2. Ports:
    - Abstractions that define how external systems interact with the domain logic.
    - Inbound Ports: Define the use cases or application services exposed by the system (e.g., APIs, commands).
    - Outbound Ports: Define the contracts for external systems the application relies on (e.g., repositories, message
      queues).
3. Adapters:
    - Concrete implementations of the ports.
    - Inbound Adapters: Translate external inputs (e.g., HTTP requests, CLI commands) into use case invocations.
    - Outbound Adapters: Implement interactions with external systems (e.g., databases, third-party APIs).
4. Dependency Rule:
    - Dependencies point inward, meaning external systems depend on the domain, not the other way around.
    - The core domain is ignorant of the outer layers.

### Best Practices

1. Interface-Driven Design:
    - Define clear, concise interfaces for both inbound and outbound ports.
2. Keep the Core Pure:
    - Avoid introducing infrastructure or framework dependencies into the domain and application layers.
3. Automate Testing:
    - Write unit tests for domain and application layers and integration tests for adapters.
4. Minimize Adapters Initially:
    - Start with simple adapters and evolve them as needed.
5. Use Dependency Injection:
    - Inject adapter implementations into the application layer, adhering to the Dependency Inversion Principle.

### Challenges

1. Learning Curve:
    - Developers unfamiliar with this style may need training to grasp its principles.
2. Overhead for Simple Applications:
    - May add unnecessary complexity for small or straightforward systems.
3. Code Proliferation:
    - Ports and adapters often lead to additional layers and interfaces, increasing the codebase size.
