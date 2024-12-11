# Tech Stack

This document outlines the technologies and tools used in the project.

---

## Backend

- **Programming Language:** PHP 8.2
- **Framework:** [Symfony 7.2](https://symfony.com)
- **Testing Framework:** [PHPUnit](https://phpunit.de) and [Codeception](https://codeception.com)
- **Database:** [PostgreSQL 17.2](https://postgresql.org)
- **Message Queue:** [RabbitMQ](https://rabbitmq.com)
- **Search Engine:** [Elasticsearch](https://elastic.co/elasticsearch)
- **Libraries:**
  - `league/openapi-psr7-validator`: API validation
  - `phpstan`: static code analysis

---

## DevOps

- **Containerization:** [Docker](https://docker.com)
- **CI/CD:** [GitHub Actions](https://github.com/features/actions)
- **Orchestration:** [Kubernetes](https://kubernetes.io)
- **Monitoring:** [Prometheus](https://prometheus.io) and [Grafana](https://grafana.com)
- **Version Control:** [Git](https://git-scm.com) with [GitHub](https://github.com)

---

## Tools and Utilities

- **Code Editor:** [PhpStorm](https://www.jetbrains.com/phpstorm)

---

## Rationale for Choices
- **PHP and Symfony:** Chosen for robustness and rich ecosystem for backend development.
- **RabbitMQ:** Supports reliable message processing in a distributed system.
- **Docker:** Simplifies environment setup and ensures consistency across development and production.
