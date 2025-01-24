# Tech Stack

## Backend

- **Programming Language:** [PHP 8.3](https://www.php.net)
- **Framework:** [Symfony 7.2](https://symfony.com)
- **Testing Framework:** [PHPUnit](https://phpunit.de) and [Codeception](https://codeception.com)
- **Database:** [PostgreSQL 17.2](https://postgresql.org)
- **Message Queue:** [RabbitMQ](https://rabbitmq.com)
- **Search Engine:** [Elasticsearch](https://elastic.co/elasticsearch)

### Main Dependencies

- [`ext-ctype`](https://www.php.net/manual/en/book.ctype.php) (required by `symfony/skeleton`):
    - A PHP extension required by Symfony for character type checks.
- [`ext-iconv`](https://www.php.net/manual/en/book.iconv.php) (required by `symfony/skeleton`):
    - A PHP extension required by Symfony for string encoding and conversion.
- [`api-platform/doctrine-orm`](https://github.com/api-platform/doctrine-orm) (required by `api-platform/api-pack`):
    - Provides integration of API Platform with the Doctrine ORM, allowing you to create RESTful APIs automatically
      from Doctrine entities.
- [`api-platform/symfony`](https://github.com/api-platform/symfony) (required by `api-platform/api-pack`):
    - The main Symfony integration for API Platform, providing configuration and customizations for your API.
- [`doctrine/dbal`](https://github.com/doctrine/dbal) (required by `api-platform/api-pack`):
    - The database abstraction layer for Doctrine. Provides database interaction, schema introspection, and SQL
      building capabilities.
- [`doctrine/doctrine-bundle`](https://github.com/doctrine/DoctrineBundle) (required by `api-platform/api-pack`):
    - Symfony bundle for integrating Doctrine ORM into the framework, offering configuration, console commands, etc.
- [`doctrine/doctrine-migrations-bundle`](https://github.com/doctrine/DoctrineMigrationsBundle) (required by
  `api-platform/api-pack`):
    - Adds database migrations functionality to Symfony, enabling version control for database schemas.
- [`doctrine/orm`](https://github.com/doctrine/orm) (required by `api-platform/api-pack`):
    - The Doctrine ORM (Object-Relational Mapper). Mainly used for mapping database tables/entities to PHP classes.
- [`eqs/health-check-provider`](https://github.com/eqsgroup/health-check-provider):
    - Enables integrating health checks to ensure the application and its components (e.g., database or external
      dependencies) are functioning correctly and accessible.
- [`nelmio/cors-bundle`](https://github.com/nelmio/NelmioCorsBundle) (required by `api-platform/api-pack`):
    - Simplifies managing CORS (Cross-Origin Resource Sharing) headers, crucial for APIs that may be accessed from
      different origins.
- [`nyholm/psr`](https://github.com/Nyholm/psr7) (supplements `eqs/health-check-provider`):
    - A lightweight and fast implementation of the PSR-7 (HTTP Message Interface) standard.
    - Provides classes for representing HTTP requests, responses, streams, URIs, and uploaded files, enabling
      interoperability between different libraries and frameworks that adhere to the PSR-7 standard.
    - This package is commonly used in applications to manage HTTP messages in a standardized way.
- [`phpdocumentor/reflection-docblock`](https://github.com/phpDocumentor/ReflectionDocBlock) (required by
  `api-platform/api-pack`):
    - Library for parsing PHP docblocks and annotations, useful for documenting your code.
- [`phpstan/phpdoc-parser`](https://github.com/phpstan/phpdoc-parser) (required by `api-platform/api-pack`):
    - A parser for PHPDoc comments to improve typing or integration with static analysis tools.
- [`runtime/frankenphp-symfony`](https://github.com/dunglas/frankenphp) (required by `symfony/skeleton`):
    - This package helps Symfony applications integrate seamlessly with FrankenPHP, which is a fast PHP application
      server.
- [`symfony/asset`](https://github.com/symfony/asset) (required by `api-platform/api-pack`):
    - Provides features for managing web assets such as CSS, JS, or images in Symfony applications.
- [`symfony/console`](https://github.com/symfony/console) (required by `symfony/skeleton`):
    - Provides Symfony's user-friendly console commands for managing applications from the command line.
- [`symfony/dotenv`](https://github.com/symfony/dotenv) (required by `symfony/skeleton`):
    - Allows loading environment variables from a `.env` file to configure the application.
- [`symfony/expression-language`](https://github.com/symfony/expression-language) (required by `api-platform/api-pack`):
    - Adds support for a dynamic expression language, often used in security and workflow rules.
- [`symfony/flex`](https://github.com/symfony/flex) (required by `symfony/skeleton`):
    - A Composer plugin that simplifies managing Symfony projects by automating certain configurations and
      dependencies.
- [`symfony/framework-bundle`](https://github.com/symfony/framework-bundle) (required by `symfony/skeleton`):
    - Core Symfony framework tools, providing services like routing, HTTP handling, and other foundational
      capabilities.
- [`symfony/messenger`](https://github.com/symfony/messenger):
    - Provides tools to manage message-driven architectures in your application.
- [`symfony/monolog-bundle`](https://github.com/symfony/monolog-bundle) (required by `symfony/debug-pack`):
    - Enables logging in Symfony applications using Monolog, a powerful logging library.
    - Lets you send logs to files, databases, emails, or third-party services (e.g., Slack or Loggly), which is
      especially useful during debugging.
- [`symfony/property-access`](https://github.com/symfony/property-access) (required by `api-platform/api-pack`):
    - Handles access to object properties dynamically, often used in forms and serialization.
- [`symfony/property-info`](https://github.com/symfony/property-info) (required by `api-platform/api-pack`):
    - Offers introspection of object properties, such as determining their type for validation or serialization.
- [`symfony/runtime`](https://github.com/symfony/runtime) (required by `symfony/skeleton`):
    - Manages runtime settings and optimizes bootstrapping for Symfony applications.
- [`symfony/security-bundle`](https://github.com/symfony/security-bundle) (required by `api-platform/api-pack`):
    - A bundle for implementing various security features like authentication, roles, and firewalls.
- [`symfony/serializer`](https://github.com/symfony/serializer) (required by `api-platform/api-pack`):
    - Provides serialization and deserialization of objects into formats like JSON or XML.
- [`symfony/twig-bundle`](https://github.com/symfony/twig-bundle) (required by `api-platform/api-pack`):
    - Integrates the Twig templating engine into Symfony applications.
- [`symfony/validator`](https://github.com/symfony/validator) (required by `api-platform/api-pack`):
    - Validates objects or data values using Symfony's validation component based on constraints.
- [`symfony/yaml`](https://github.com/symfony/yaml) (required by `symfony/skeleton`):
    - Offers tools to parse, dump, and use YAML configuration files.
- [`webmozart/assert`](https://github.com/webmozart/assert):
    - A lightweight PHP library used for making assertions in your application.

### Dev Dependencies

- [`captainhook/captainhook-phar`](https://github.com/CaptainHookPhp/captainhook):
    - A PHP tool for managing Git hooks.
    - Automates the setup and execution of Git hooks, allowing developers to define custom actions, such as code quality
      checks, tests, or formatting fixes, that run during Git events like commit or push.
- [`codeception/codeception`](https://github.com/Codeception/Codeception):
    - Codeception is a testing framework for PHP applications. It allows for creating unit, functional, and
      acceptance tests.
- [`codeception/module-doctrine`](https://github.com/Codeception/module-doctrine) (supplements
  `codeception/codeception`):
    - A Codeception module designed for integration testing in applications that use Doctrine ORM.
    - Provides tools to interact with the database during tests, including features to control the Doctrine Entity
      Manager, handle database transactions, clean the database, and populate it with fixtures.
- [`codeception/module-rest`](https://github.com/Codeception/module-rest) (supplements `codeception/codeception`):
    - A Codeception module which allows tests to communicate with REST APIs and validate responses.
- [`codeception/module-symfony`](https://github.com/Codeception/module-symfony) (supplements `codeception/codeception`):
    - A Codeception module which integrates with Symfony internals, allowing deeper functional and integration
      testing.
- [`mikelgoig/codeception-openapi`](https://github.com/mikelgoig/codeception-openapi) (supplements
  `codeception/codeception`):
    - A Codeception module for contract testing with OpenAPI.
- [`mikelgoig/codeception-rest`](https://github.com/mikelgoig/codeception-rest) (supplements `codeception/codeception`):
    - A Codeception module for testing REST services.
- [`mikelgoig/easy-coding-standard-rules`](https://github.com/mikelgoig/easy-coding-standard-rules) (supplements
  `symplify/easy-coding-standard`):
    - Provides a collection of custom rules for use with Symplify's Easy Coding Standard (ECS).
    - These rules help enforce specific code quality and consistency standards in a PHP codebase, extending the
      functionality of ECS with additional checks and fixes tailored to improve code style and maintainability.
- [`phpstan/extension-installer`](https://github.com/phpstan/extension-installer) (supplements `phpstan/phpstan`):
    - A composer plugin designed to simplify the installation and configuration of PHPStan extensions.
    - Automatically registers installed extensions, eliminating the need for manual configuration in PHPStan's settings.
- [`phpstan/phpstan`](https://github.com/phpstan/phpstan):
    - A popular static analysis tool for PHP.
    - Helps developers identify potential bugs, type errors, and other code issues without running the application.
    - By analyzing the codebase based on defined rules and type hints, PHPStan enforces stricter type safety and
      improves overall code quality.
- [`phpstan/phpstan-deprecation-rules`](https://github.com/phpstan/phpstan-deprecation-rules) (supplements
  `phpstan/phpstan`):
    - Provides a set of PHPStan rules specifically designed to detect and report the usage of deprecated code in a
      project.
    - Helps developers identify and replace deprecated classes, methods, or functions, ensuring the code remains
      up-to-date and compatible with future dependencies or PHP versions.
- [`phpstan/phpstan-doctrine`](https://github.com/phpstan/phpstan-doctrine) (supplements `phpstan/phpstan`):
    - Adds specific PHPStan rules and features to analyze projects using Doctrine ORM and DBAL.
    - Provides deeper insights into Doctrine entities, repositories, and queries, helping to detect issues with
      annotations, mappings, repositories, and database interactions.
- [`phpstan/phpstan-strict-rules`](https://github.com/phpstan/phpstan-strict-rules) (supplements `phpstan/phpstan`):
    - Introduces strict rules for PHPStan, aiming to enforce stricter coding standards and reduce potential bugs.
    - Detects issues like redundant code, risky type assumptions, and enforces rigorous type safety, ensuring more
      robust and clean code.
- [`phpstan/phpstan-symfony`](https://github.com/phpstan/phpstan-symfony) (supplements `phpstan/phpstan`):
    - Integrates PHPStan with Symfony projects to provide a deeper understanding of Symfony-specific components, like
      services, controllers, and configuration files.
    - Helps uncover issues specific to Symfony applications, such as incorrect service definitions or misconfigurations.
- [`phpstan/phpstan-webmozart-assert`](https://github.com/phpstan/phpstan-webmozart-assert) (supplements
  `phpstan/phpstan`):
    - Provides PHPStan rules for analyzing and validating the proper usage of the `webmozart/assert` assertions library.
    - Ensures that assertions in the code are used correctly (e.g., proper types, arguments, and logic).
- [`ramsey/conventional-commits`](https://github.com/ramsey/conventional-commits):
    - Helps validate and enforce the [Conventional Commits](https://www.conventionalcommits.org/) specification in a
      project.
    - It's typically used to ensure that commit messages follow a structured format, making it easier to generate
      changelogs and maintain consistent versioning.
- [`symfony/debug-bundle`](https://github.com/symfony/debug-bundle) (required by `symfony/debug-pack`):
    - Integrates debugging tools with Symfony's services in the framework.
    - Provides features like setting up a debug container and additional diagnostics.
- [`symfony/maker-bundle`](https://github.com/symfony/maker-bundle):
    - Simplifies the process of generating common code and features.
    - Provides interactive commands that developers can use to scaffold different parts of the application, such as
      controllers, entities, form classes, tests, and more.
- [`symfony/stopwatch`](https://github.com/symfony/stopwatch) (required by `symfony/debug-pack`):
    - Measures the performance or execution time of your application code.
    - It is useful for profiling and debugging code sections to determine their duration and performance impact.
- [`symfony/web-profiler-bundle`](https://github.com/symfony/web-profiler-bundle) (required by `symfony/debug-pack`):
    - Displays the Web Debug Toolbar and integrates the Symfony Profiler.
    - Provides insight into routes, queries, logs, and more during development.
- [`symplify/easy-coding-standard`](https://github.com/easy-coding-standard/easy-coding-standard):
    - A tool for managing and running automated code style checks and fixes in PHP projects.
    - Integrates popular tools like PHP_CodeSniffer and PHP-CS-Fixer, providing a streamlined way to enforce and fix
      coding standards across a codebase.
- [`symplify/phpstan-rules`](https://github.com/symplify/phpstan-rules) (supplements `phpstan/phpstan`):
    - Provides a set of custom PHPStan rules aimed at improving code quality and maintaining best practices.
    - Adds additional checks for cleaner, more robust, and maintainable PHP code.

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
