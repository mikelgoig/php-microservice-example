# Tech Stack

## Backend

- **Programming Language:** PHP 8.2
- **Framework:** [Symfony 7.2](https://symfony.com)
- **Testing Framework:** [PHPUnit](https://phpunit.de) and [Codeception](https://codeception.com)
- **Database:** [PostgreSQL 17.2](https://postgresql.org)
- **Message Queue:** [RabbitMQ](https://rabbitmq.com)
- **Search Engine:** [Elasticsearch](https://elastic.co/elasticsearch)
- **Main Dependencies:**
    - `ext-ctype` (`symfony/skeleton`):
        - A PHP extension required by Symfony for character type checks.
    - `ext-iconv` (`symfony/skeleton`):
        - A PHP extension required by Symfony for string encoding and conversion.
    - `api-platform/doctrine-orm` (`symfony/skeleton`):
        - Provides integration of API Platform with the Doctrine ORM, allowing you to create RESTful APIs automatically
          from Doctrine entities.
    - `api-platform/symfony` (`api-platform/api-pack`):
        - The main Symfony integration for API Platform, providing configuration and customizations for your API.
    - `doctrine/dbal` (`api-platform/api-pack`):
        - The database abstraction layer for Doctrine. Provides database interaction, schema introspection, and SQL
          building capabilities.
    - `doctrine/doctrine-bundle` (`api-platform/api-pack`):
        - Symfony bundle for integrating Doctrine ORM into the framework, offering configuration, console commands, etc.
    - `doctrine/doctrine-migrations-bundle` (`api-platform/api-pack`):
        - Adds database migrations functionality to Symfony, enabling version control for database schemas.
    - `doctrine/orm` (`api-platform/api-pack`):
        - The Doctrine ORM (Object-Relational Mapper). Mainly used for mapping database tables/entities to PHP classes.
    - `nelmio/cors-bundle` (`api-platform/api-pack`):
        - Simplifies managing CORS (Cross-Origin Resource Sharing) headers, crucial for APIs that may be accessed from
          different origins.
    - `phpdocumentor/reflection-docblock` (`api-platform/api-pack`):
        - Library for parsing PHP docblocks and annotations, useful for documenting your code.
    - `phpstan/phpdoc-parser` (`api-platform/api-pack`):
        - A parser for PHPDoc comments to improve typing or integration with static analysis tools.
    - `runtime/frankenphp-symfony` (`symfony/skeleton`):
        - This package helps Symfony applications integrate seamlessly with FrankenPHP, which is a fast PHP application
          server.
    - `symfony/asset` (`api-platform/api-pack`):
        - Provides features for managing web assets such as CSS, JS, or images in Symfony applications.
    - `symfony/console` (`symfony/skeleton`):
        - Provides Symfony's user-friendly console commands for managing applications from the command line.
    - `symfony/dotenv` (`symfony/skeleton`):
        - Allows loading environment variables from a `.env` file to configure the application.
    - `symfony/expression-language` (`api-platform/api-pack`):
        - Adds support for a dynamic expression language, often used in security and workflow rules.
    - `symfony/flex` (`symfony/skeleton`):
        - A Composer plugin that simplifies managing Symfony projects by automating certain configurations and
          dependencies.
    - `symfony/framework-bundle` (`symfony/skeleton`):
        - Core Symfony framework tools, providing services like routing, HTTP handling, and other foundational
          capabilities.
    - `symfony/monolog-bundle` (`symfony/debug-pack`):
        - Enables logging in Symfony applications using Monolog, a powerful logging library.
        - Lets you send logs to files, databases, emails, or third-party services (e.g., Slack or Loggly), which is
          especially useful during debugging.
    - `symfony/property-access` (`api-platform/api-pack`):
        - Handles access to object properties dynamically, often used in forms and serialization.
    - `symfony/property-info` (`api-platform/api-pack`):
        - Offers introspection of object properties, such as determining their type for validation or serialization.
    - `symfony/runtime` (`symfony/skeleton`):
        - Manages runtime settings and optimizes bootstrapping for Symfony applications.
    - `symfony/security-bundle` (`api-platform/api-pack`):
        - A bundle for implementing various security features like authentication, roles, and firewalls.
    - `symfony/serializer` (`api-platform/api-pack`):
        - Provides serialization and deserialization of objects into formats like JSON or XML.
    - `symfony/twig-bundle` (`api-platform/api-pack`):
        - Integrates the Twig templating engine into Symfony applications.
    - `symfony/validator` (`api-platform/api-pack`):
        - Validates objects or data values using Symfony's validation component based on constraints.
    - `symfony/yaml` (`symfony/skeleton`):
        - Offers tools to parse, dump, and use YAML configuration files.
- **Dev Dependencies:**
    - `symfony/debug-bundle` (`symfony/debug-pack`):
        - Integrates debugging tools with Symfony's services in the framework.
        - Provides features like setting up a debug container and additional diagnostics.
    - `symfony/stopwatch` (`symfony/debug-pack`):
        - Measures the performance or execution time of your application code.
        - It is useful for profiling and debugging code sections to determine their duration and performance impact.
    - `symfony/web-profiler-bundle` (`symfony/debug-pack`):
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
