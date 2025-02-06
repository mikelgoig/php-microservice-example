# Doctrine

This document explains how to configure Doctrine entity mappings in a Symfony application. Proper configuration ensures
that Doctrine can locate, load, and manage your entities effectively.

---

## Mapping Doctrine Entities in Symfony

When configuring Doctrine in a Symfony application, you need to map your entity namespaces and directories to ensure
Doctrine can locate and manage them properly.

1. Open your Doctrine configuration file, typically located in the `config/packages` directory (e.g., `doctrine.yaml`).

2. Specify the mapping configuration for the desired namespace, directory, and related settings.

    Below is an example of mapping Doctrine entities for the `Catalog` context:

    ```yaml
    # service/config/packages/doctrine.yaml
    
    doctrine:
      orm:
        mappings:
          Catalog: # Custom mapping name
            type: attribute # Specifies annotations, attributes, or XML mapping (we use attributes)
            dir: '%kernel.project_dir%/src/Catalog/Infrastructure/Doctrine' # Path to the directory where entities are stored
            prefix: 'App\Catalog\Infrastructure\Doctrine' # Namespace prefix for the entities
            is_bundle: false
    ```

---

## Excluding Doctrine Entities from Being Configured as Symfony Services

When working with Symfony and Doctrine, there might be cases where you want to exclude specific Doctrine entities from
being automatically registered as services. This can be achieved in your Symfony service configuration file.

1. Open the Symfony service configuration file.

2. Use the `exclude` parameter to explicitly list the entities you want to exclude.

   Here’s an example for the `Catalog` context:

    ```yaml
    # service/config/contexts/catalog.yaml
    
    services:
      App\Catalog\:
        resource: '../../src/Catalog/'
        exclude: # Explicitly exclude specific files/entities
          - '../../src/Catalog/Infrastructure/Doctrine/Book/Book.php'
    ```
