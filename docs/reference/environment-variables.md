# Environment Variables

This document describes the environment variables required to run the application and how to set them up.

---

## Configuration Based on Environment Variables

In all environments, the following files are loaded if they exist, the latter taking precedence over the former:

- `.env`: contains default values for the environment variables needed by the app
- `.env.local`: uncommitted file with local overrides
- `.env.$APP_ENV`: committed environment-specific defaults
- `.env.$APP_ENV.local`: uncommitted environment-specific overrides

Real environment variables win over `.env` files.

**In production, we run the `composer dump-env prod --empty` command to generate an empty `.env.local.php` file to rely
only on real environment variables**.

---

## Third-Party Environment Variables

| Name                         | Description                                                                                                                                                                                                                                                                                                                                                                     | Example Value                                                                           |
|------------------------------|---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|-----------------------------------------------------------------------------------------|
| **doctrine/doctrine-bundle** |
| `DATABASE_URL`               | <p>The database connection information.</p><p>IMPORTANT: You MUST configure your server version.</p><p>More info: https://www.doctrine-project.org/projects/doctrine-dbal/en/latest/reference/configuration.html#connecting-using-a-url.</p>                                                                                                                                    | `postgresql://db_user:db_password@127.0.0.1:5432/db_name?serverVersion=15&charset=utf8` |
| **dunglas/symfony-docker**   |
| `SERVER_NAME`                | <p>The server name or address</p><p>More info: https://github.com/dunglas/symfony-docker/blob/main/docs/options.md</p>                                                                                                                                                                                                                                                          | `localhost`                                                                             |
| **nelmio/cors-bundle**       |
| `CORS_ALLOW_ORIGIN`          | <p>The allowed origins for Cross-Origin Resource Sharing (CORS).</p><p>More info: https://symfony.com/bundles/NelmioCorsBundle/current/index.html</p>                                                                                                                                                                                                                           | `^https?://(127\.0\.0\.1)(:[0-9]+)?$`                                                   |
| **symfony/framework-bundle** |
| `APP_ENV`                    | <p>The Symfony's configuration environment in which the application runs.</p><p>We have three options: `dev` for development, `prod` for production servers, and `test` for automated tests.</p><p>More info: https://symfony.com/doc/current/configuration.html#configuration-environments</p>                                                                                 | `dev`                                                                                   |
| `APP_SECRET`                 | <p>This is a string that should be unique to your application and it's commonly used to add more entropy to security related operations. Its value should be a series of characters, numbers and symbols chosen randomly and the recommended length is around 32 characters.</p><p>More info: https://symfony.com/doc/current/reference/configuration/framework.html#secret</p> | `69564667e68d49a9c017f679b4c501f6`                                                      |
| **symfony/messenger**        |
| `MESSENGER_TRANSPORT_DSN`    | <p>The messenger transport information</p><p>More info: https://symfony.com/doc/current/messenger.html#transports-async-queued-messages</p>                                                                                                                                                                                                                                     | `doctrine://default`                                                                    |
