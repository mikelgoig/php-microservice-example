# Branching Strategy

The project follows the [**Trunk-Based Development**](https://trunkbaseddevelopment.com) strategy, which emphasizes
continuous integration of small, frequent changes into a single, shared branch, `main`.

This strategy minimizes branching and focuses on collaboration, speed, and simplicity, ensuring that the `main` branch
is always in a deployable state.

---

## Key Principles

1. **Single Main Branch**
    - The `main` branch is the only long-lived branch.
    - All development happens directly on `main` or short-lived feature branches.

2. **Short-Lived Feature Branches**
    - Feature branches are optional and used only for complex changes.
    - Branches are merged back to `main` as quickly as possible, typically within a day or two.

3. **Frequent Commits**
    - Developers commit changes frequently and ensure that the code is buildable and tested before committing.

4. **Continuous Integration**
    - CI/CD pipelines automatically run on every commit to `main`, ensuring code quality and immediate feedback.

5. **Feature Flags**
    - Incomplete or experimental features are hidden behind **feature flags** to allow frequent deployment without
      exposing unfinished work.

---

## Workflow

### 1. Direct Commits to `main`

- For small, self-contained changes:
    - Work directly in the `main` branch.
    - Ensure changes pass all local tests before committing.

### 2. Short-Lived Feature Branches (Optional)

- For larger or disruptive changes:
    - Create a temporary feature branch from `main`:
      ```bash
      git checkout main
      git checkout -b feature/{short-description}
      ```
    - Merge back into `main` as soon as the feature is functional and tested:
      ```bash
      git checkout main
      git merge feature/{short-description}
      git branch -d feature/{short-description}
      ```

### 3. Feature Flags

- Use feature flags to hide incomplete functionality in production:
    - Example (pseudocode):
      ```php
      if (isFeatureEnabled('new-feature')) {
          // New feature code
      } else {
          // Fallback code
      }
      ```
- Toggle flags dynamically to enable features for testing or specific users.

### 4. CI/CD Workflow

- Every commit to `main` triggers:
    1. Automated tests (unit, integration, and component).
    2. Code quality checks (e.g., linting, static analysis).
    3. Deployment to staging or production environments (if passing).
