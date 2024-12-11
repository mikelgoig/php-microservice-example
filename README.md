<h1>
Hexagonal Architecture, CQRS, DDD & Event Sourcing in PHP
</h1>

<p>
Created by <a href="https://mikelgoig.com">Mikel Goig</a>.
</p>

<p>
    <a href="https://symfony.com">
        <img alt="Symfony 7" src="https://img.shields.io/badge/Symfony-7-purple.svg?style=flat-square&logo=symfony"/>
    </a>
</p>

<p>
    <a href="https://github.com/mikelgoig/php-sandbox-project">
        View Repository
    </a>
</p>

---

Sandbox project of a **PHP microservice using Hexagonal Architecture, CQRS, DDD and Event Sourcing**, keeping the code
as simple as possible.

This microservice is just a component of a **Bookshop System**, which is in charge of managing the book catalog.

The project runs on a [Docker](https://www.docker.com)-based installer and runtime for the
[Symfony](https://symfony.com) web framework, with [FrankenPHP](https://frankenphp.dev) and
[Caddy](https://caddyserver.com) inside!

## 😎 Getting Started

### 🐳 Needed Tools

- [Docker Compose](https://docs.docker.com/compose/install) (v2.10+)

### 🦊 Code

1. Clone this project:

    ```bash
    git clone https://github.com/mikelgoig/php-sandbox-project.git
    ```

2. Move to the project folder:

    ```bash
    cd php-sandbox-project
    ```

### 🔥 Execution

1. Start the project with Docker executing:

    ```bash
    make start
    ```

2. Then you'll have the application available at https://localhost.

3. [Accept the auto-generated TLS certificate](https://stackoverflow.com/questions/7580508/getting-chrome-to-accept-self-signed-localhost-certificate/15076602#15076602).

4. Stop the Docker containers:

    ```bash
    make down
    ```

### ✅ Tests

_TO DO_

## 👩‍💻 Project Explanation

### Architecture

- [System Architecture Style](docs/architecture/architecture-style.md)
- [Architecture Diagrams](docs/architecture/architecture-diagrams.md)
- [Tech Stack](docs/architecture/tech-stack.md)
- [Bounded Contexts](docs/architecture/bounded-contexts.md)
- [Use Cases](docs/architecture/use-cases.md)

### Version Control

- [Branching Strategy](docs/version-control/branching-strategy.md)

### Deployment

- [Deployment Model](docs/deployment/deployment-model.md)

## 🤩 Extra

This sandbox project has been created using both templates [symfony/skeleton](https://github.com/dunglas/symfony-docker)
and [dunglas/symfony-docker](https://github.com/dunglas/symfony-docker).

This README has been written using this [README checklist](https://github.com/ddbeck/readme-checklist).
