# Tech Stack

## Backend

- **Programming Language:** PHP 8.2
- **Framework:** [Symfony 7.2](https://symfony.com)
- **Testing Framework:** [PHPUnit](https://phpunit.de) and [Codeception](https://codeception.com)
- **Database:** [PostgreSQL 17.2](https://postgresql.org)
- **Message Queue:** [RabbitMQ](https://rabbitmq.com)
- **Search Engine:** [Elasticsearch](https://elastic.co/elasticsearch)
- **Main Dependencies:**
    - `ext-ctype`:
        - A PHP extension required by Symfony for character type checks.
    - `ext-iconv`:
        - A PHP extension required by Symfony for string encoding and conversion.
    - `runtime/frankenphp-symfony`:
        - This package helps Symfony applications integrate seamlessly with FrankenPHP, which is a fast PHP application
          server.
    - `symfony/console`:
        - Provides Symfony's user-friendly console commands for managing applications from the command line.
    - `symfony/dotenv`:
        - Allows loading environment variables from a `.env` file to configure the application.
    - `symfony/flex`:
        - A Composer plugin that simplifies managing Symfony projects by automating certain configurations and
          dependencies.
    - `symfony/framework-bundle`:
        - Core Symfony framework tools, providing services like routing, HTTP handling, and other foundational
          capabilities.
    - `symfony/monolog-bundle`:
        - Enables logging in Symfony applications using Monolog, a powerful logging library.
        - Lets you send logs to files, databases, emails, or third-party services (e.g., Slack or Loggly), which is
          especially useful during debugging.
    - `symfony/runtime`:
        - Manages runtime settings and optimizes bootstrapping for Symfony applications.
    - `symfony/yaml`:
        - Offers tools to parse, dump, and use YAML configuration files.
- **Dev Dependencies:**
    - `symfony/debug-bundle`:
        - Integrates debugging tools with Symfony's services in the framework.
        - Provides features like setting up a debug container and additional diagnostics.
    - `symfony/stopwatch`:
        - Measures the performance or execution time of your application code.
        - It is useful for profiling and debugging code sections to determine their duration and performance impact.
    - `symfony/web-profiler-bundle`:
        - Displays the Web Debug Toolbar and integrates the Symfony Profiler.
        - Provides insight into routes, queries, logs, and more during development.

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
