# Tech Stack

## Backend

- **Programming Language:** [PHP 8.3](https://www.php.net)
- **Framework:** [Symfony 7.2](https://symfony.com), [API Platform 4](https://api-platform.com)
  and [Ecotone](https://ecotone.tech)
- **Testing Framework:** [PHPUnit 11](https://phpunit.de)
- **Database:** [PostgreSQL 17.2](https://postgresql.org)
- **Message Queue:** [RabbitMQ](https://rabbitmq.com)
- **Search Engine:** [Elasticsearch](https://elastic.co/elasticsearch)

### Main Dependencies

- [`ext-ctype`](https://www.php.net/manual/en/book.ctype.php) (installed by `symfony/skeleton`):
    - A PHP extension required by Symfony for character type checks.
- [`ext-iconv`](https://www.php.net/manual/en/book.iconv.php) (installed by `symfony/skeleton`):
    - A PHP extension required by Symfony for string encoding and conversion.
- [`api-platform/doctrine-orm`](https://github.com/api-platform/doctrine-orm) (installed by `api-platform/api-pack`):
    - Provides integration of API Platform with the Doctrine ORM, allowing you to create RESTful APIs automatically
      from Doctrine entities.
- [`api-platform/symfony`](https://github.com/api-platform/symfony) (installed by `api-platform/api-pack`):
    - The main Symfony integration for API Platform, providing configuration and customizations for your API.
- [`doctrine/dbal`](https://github.com/doctrine/dbal) (installed by `api-platform/api-pack`):
    - The database abstraction layer for Doctrine. Provides database interaction, schema introspection, and SQL
      building capabilities.
- [`doctrine/doctrine-bundle`](https://github.com/doctrine/DoctrineBundle) (installed by `api-platform/api-pack`):
    - Symfony bundle for integrating Doctrine ORM into the framework, offering configuration, console commands, etc.
- [`doctrine/doctrine-migrations-bundle`](https://github.com/doctrine/DoctrineMigrationsBundle) (installed by
  `api-platform/api-pack`):
    - Adds database migrations functionality to Symfony, enabling version control for database schemas.
- [`doctrine/orm`](https://github.com/doctrine/orm) (installed by `api-platform/api-pack`):
    - The Doctrine ORM (Object-Relational Mapper). Mainly used for mapping database tables/entities to PHP classes.
- [`ecotone/jms-converter`](https://github.com/ecotoneframework/jms-converter) (supplements `ecotone/symfony-bundle`):
    - Allows serialization and deserialization of messages in a standardized format, enabling communication between
      different systems or components.
- [`ecotone/pdo-event-sourcing`](https://github.com/ecotoneframework/pdo-event-sourcing) (supplements
  `ecotone/symfony-bundle`):
    - Implements event sourcing using PDO (PHP Data Objects).
    - Helps in persisting domain events in relational databases and recreating the application's state by replaying
      those events.
    - It's widely used in event-driven architectures to handle event streams efficiently.
- [`ecotone/symfony-bundle`](https://github.com/ecotoneframework/symfony-bundle):
    - A Symfony bundle for integrating Ecotone into Symfony projects.
    - Simplifies the setup of messaging, event sourcing, and other Ecotone functionalities within the Symfony framework.
    - Enables developers to use Ecotone seamlessly within their Symfony-based applications.
- [`eqs/health-check-provider`](https://github.com/eqsgroup/health-check-provider):
    - Enables integrating health checks to ensure the application and its components (e.g., database or external
      dependencies) are functioning correctly and accessible.
- [`nelmio/cors-bundle`](https://github.com/nelmio/NelmioCorsBundle) (installed by `api-platform/api-pack`):
    - Simplifies managing CORS (Cross-Origin Resource Sharing) headers, crucial for APIs that may be accessed from
      different origins.
- [`nyholm/psr`](https://github.com/Nyholm/psr7) (supplements `eqs/health-check-provider`):
    - A lightweight and fast implementation of the PSR-7 (HTTP Message Interface) standard.
    - Provides classes for representing HTTP requests, responses, streams, URIs, and uploaded files, enabling
      interoperability between different libraries and frameworks that adhere to the PSR-7 standard.
    - This package is commonly used in applications to manage HTTP messages in a standardized way.
- [`phpdocumentor/reflection-docblock`](https://github.com/phpDocumentor/ReflectionDocBlock) (installed by
  `api-platform/api-pack`):
    - Library for parsing PHP docblocks and annotations, useful for documenting your code.
- [`phpstan/phpdoc-parser`](https://github.com/phpstan/phpdoc-parser) (installed by `api-platform/api-pack`):
    - A parser for PHPDoc comments to improve typing or integration with static analysis tools.
- [`runtime/frankenphp-symfony`](https://github.com/dunglas/frankenphp) (installed by `symfony/skeleton`):
    - This package helps Symfony applications integrate seamlessly with FrankenPHP, which is a fast PHP application
      server.
- [`symfony/asset`](https://github.com/symfony/asset) (installed by `api-platform/api-pack`):
    - Provides features for managing web assets such as CSS, JS, or images in Symfony applications.
- [`symfony/console`](https://github.com/symfony/console) (installed by `symfony/skeleton`):
    - Provides Symfony's user-friendly console commands for managing applications from the command line.
- [`symfony/dotenv`](https://github.com/symfony/dotenv) (installed by `symfony/skeleton`):
    - Allows loading environment variables from a `.env` file to configure the application.
- [`symfony/expression-language`](https://github.com/symfony/expression-language) (installed by
  `api-platform/api-pack`):
    - Adds support for a dynamic expression language, often used in security and workflow rules.
- [`symfony/flex`](https://github.com/symfony/flex) (installed by `symfony/skeleton`):
    - A Composer plugin that simplifies managing Symfony projects by automating certain configurations and
      dependencies.
- [`symfony/framework-bundle`](https://github.com/symfony/framework-bundle) (installed by `symfony/skeleton`):
    - Core Symfony framework tools, providing services like routing, HTTP handling, and other foundational
      capabilities.
- [`symfony/messenger`](https://github.com/symfony/messenger):
    - Provides tools to manage message-driven architectures in your application.
- [`symfony/monolog-bundle`](https://github.com/symfony/monolog-bundle) (installed by `symfony/debug-pack`):
    - Enables logging in Symfony applications using Monolog, a powerful logging library.
    - Lets you send logs to files, databases, emails, or third-party services (e.g., Slack or Loggly), which is
      especially useful during debugging.
- [`symfony/property-access`](https://github.com/symfony/property-access) (installed by `api-platform/api-pack`):
    - Handles access to object properties dynamically, often used in forms and serialization.
- [`symfony/property-info`](https://github.com/symfony/property-info) (installed by `api-platform/api-pack`):
    - Offers introspection of object properties, such as determining their type for validation or serialization.
- [`symfony/runtime`](https://github.com/symfony/runtime) (installed by `symfony/skeleton`):
    - Manages runtime settings and optimizes bootstrapping for Symfony applications.
- [`symfony/security-bundle`](https://github.com/symfony/security-bundle) (installed by `api-platform/api-pack`):
    - A bundle for implementing various security features like authentication, roles, and firewalls.
- [`symfony/serializer`](https://github.com/symfony/serializer) (installed by `api-platform/api-pack`):
    - Provides serialization and deserialization of objects into formats like JSON or XML.
- [`symfony/twig-bundle`](https://github.com/symfony/twig-bundle) (installed by `api-platform/api-pack`):
    - Integrates the Twig templating engine into Symfony applications.
- [`symfony/validator`](https://github.com/symfony/validator) (installed by `api-platform/api-pack`):
    - Validates objects or data values using Symfony's validation component based on constraints.
- [`symfony/yaml`](https://github.com/symfony/yaml) (installed by `symfony/skeleton`):
    - Offers tools to parse, dump, and use YAML configuration files.
- [`symfonycasts/micro-mapper`](https://github.com/SymfonyCasts/micro-mapper) (supplements `api-platform/api-pack`):
    - A lightweight object mapper designed to simplify mapping data from one structure to another.
    - It can be used for tasks like mapping arrays or DTOs (Data Transfer Objects) to entities and vice versa, making
      the handling of complex data transformation more intuitive and concise.
- [`webmozart/assert`](https://github.com/webmozart/assert):
    - A lightweight PHP library used for making assertions in your application.

### Dev Dependencies

- [`captainhook/captainhook-phar`](https://github.com/CaptainHookPhp/captainhook):
    - A PHP tool for managing Git hooks.
    - Automates the setup and execution of Git hooks, allowing developers to define custom actions, such as code quality
      checks, tests, or formatting fixes, that run during Git events like commit or push.
- [`coduo/php-matcher`](https://github.com/coduo/php-matcher) (supplements `symfony/test-pack`):
    - Used for matching patterns in more flexible ways.
    - It's often employed in testing to verify if a certain structure or data matches some predefined format, especially
      when exact values aren't required.
    - It's useful for validating JSON or other complex data structures.
- [`dama/doctrine-test-bundle`](https://github.com/dmaicher/doctrine-test-bundle) (supplements `symfony/test-pack`):
    - Simplifies database testing by wrapping Doctrine's DBAL Connection in a transactional mode.
    - Prevents database changes from persisting between tests, ensuring a clean and isolated database state for every
      test run, significantly improving testing speed.
- [`justinrainbow/json-schema`](https://github.com/justinrainbow/json-schema) (supplements `symfony/test-pack`):
    - A PHP library for validating JSON data against a schema.
    - This can be useful for ensuring that your data conforms to predefined structures, especially when working with
      APIs where data format validation is critical.
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
- [`phpstan/phpstan-phpunit`](https://github.com/phpstan/phpstan-phpunit) (supplements `phpstan/phpstan`):
    - Provides a PHPStan integration with PHPUnit.
    - Helps by analyzing PHPUnit-specific code and test cases written in your application, identifying potential bugs or
      inconsistencies in your tests.
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
- [`phpunit/phpunit`](https://github.com/sebastianbergmann/phpunit) (installed by `symfony/test-pack`):
    - The most popular PHP testing framework.
    - It's integral for creating and executing unit tests, allowing you to write assertions to validate the behavior of
      your application's code and ensure stability throughout development.
- [`ramsey/conventional-commits`](https://github.com/ramsey/conventional-commits):
    - Helps validate and enforce the [Conventional Commits](https://www.conventionalcommits.org/) specification in a
      project.
    - It's typically used to ensure that commit messages follow a structured format, making it easier to generate
      changelogs and maintain consistent versioning.
- [`symfony/browser-kit`](https://github.com/symfony/browser-kit) (installed by `symfony/test-pack`):
    - A Symfony component that simulates a web browser for testing purposes.
    - It's often used in integration or functional testing, allowing you to programmatically navigate web pages and
      interact with forms, links, etc.
- [`symfony/debug-bundle`](https://github.com/symfony/debug-bundle) (installed by `symfony/debug-pack`):
    - Integrates debugging tools with Symfony's services in the framework.
    - Provides features like setting up a debug container and additional diagnostics.
- [`symfony/http-client`](https://github.com/symfony/http-client) (supplements `symfony/test-pack`):
    - A robust HTTP client provided by Symfony for making HTTP requests.
    - Supports features like asynchronous requests, HTTP/2, and handling responses, making integrations with APIs and
      external services easier and more efficient.
- [`symfony/maker-bundle`](https://github.com/symfony/maker-bundle):
    - Simplifies the process of generating common code and features.
    - Provides interactive commands that developers can use to scaffold different parts of the application, such as
      controllers, entities, form classes, tests, and more.
- [`symfony/phpunit-bridge`](https://github.com/symfony/phpunit-bridge) (installed by `symfony/test-pack`):
    - A Symfony tool that enhances PHPUnit by providing better integration with Symfony applications.
    - Includes features like deprecation warnings during tests, autoconfiguration of the testing environment, and easier
      PHPUnit version upgrades.
- [`symfony/stopwatch`](https://github.com/symfony/stopwatch) (installed by `symfony/debug-pack`):
    - Measures the performance or execution time of your application code.
    - It is useful for profiling and debugging code sections to determine their duration and performance impact.
- [`symfony/web-profiler-bundle`](https://github.com/symfony/web-profiler-bundle) (installed by `symfony/debug-pack`):
    - Displays the Web Debug Toolbar and integrates the Symfony Profiler.
    - Provides insight into routes, queries, logs, and more during development.
- [`symplify/easy-coding-standard`](https://github.com/easy-coding-standard/easy-coding-standard):
    - A tool for managing and running automated code style checks and fixes in PHP projects.
    - Integrates popular tools like PHP_CodeSniffer and PHP-CS-Fixer, providing a streamlined way to enforce and fix
      coding standards across a codebase.
- [`symplify/phpstan-rules`](https://github.com/symplify/phpstan-rules) (supplements `phpstan/phpstan`):
    - Provides a set of custom PHPStan rules aimed at improving code quality and maintaining best practices.
    - Adds additional checks for cleaner, more robust, and maintainable PHP code.
- [`zenstruck/foundry`](https://github.com/zenstruck/foundry) (supplements `symfony/test-pack`):
    - A library for generating and managing objects using factories.
    - It's typically used to seed test databases or simplify test setup by creating entities, DTOs, or any objects with
      predefined or randomized attributes.
    - Great for functional or integration testing in Symfony projects.

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
- **API Platform:** Provides a powerful and flexible framework for building APIs, offering features like serialization,
  validation, and OpenAPI documentation out of the box.
- **Ecotone:** Enables messaging and event-driven architecture with support for event sourcing, CQRS, and asynchronous
  processing, enhancing system scalability and maintainability.
- **RabbitMQ:** Supports reliable message processing in a distributed system.
- **Docker:** Simplifies environment setup and ensures consistency across development and production.
