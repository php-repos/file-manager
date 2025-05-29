# Contributing to FileManager

Thank you for contributing to the **FileManager** package! This guide outlines the process for contributing to this PHP library for file system operations.

## Table of Contents

- [Code of Conduct](#code-of-conduct)
- [How to Contribute](#how-to-contribute)
    - [Forking and Cloning](#forking-and-cloning)
    - [Setting Up the Development Environment](#setting-up-the-development-environment)
    - [Making Changes](#making-changes)
    - [Submitting a Pull Request](#submitting-a-pull-request)
- [Coding Standards](#coding-standards)
- [Reporting Bugs](#reporting-bugs)
- [Suggesting Features](#suggesting-features)
- [Community and Support](#community-and-support)

## Code of Conduct

Please adhere to our [Code of Conduct](CODE_OF_CONDUCT.md) to ensure a positive and inclusive environment.

## How to Contribute

### Forking and Cloning

Fork the [FileManager repository](https://github.com/php-repos/file-manager.git) and clone it:

```bash
git clone https://github.com/<your-username>/file-manager.git
cd file-manager
```

Create a branch for your changes:

```bash
git checkout -b feature/<your-feature-name>
```

### Setting Up the Development Environment

1. **Prerequisites**:
    - PHP 8.2 or higher.
    - [phpkg](https://phpkg.com/) for managing dependencies.

2. **Install Dependencies**:
    - Run:
      ```bash
      phpkg install
      ```

3. **Run Tests**:
    - Build the project:
      ```bash
      phpkg build
      ```
    - Navigate to the development build directory:
      ```bash
      cd builds/development
      ```
    - Run all tests using `php-repos/test-runner`:
      ```bash
      phpkg run https://github.com/php-repos/test-runner.git
      ```
    - To run a specific test file:
      ```bash
      phpkg run https://github.com/php-repos/test-runner.git run --filter=TestPaths
      ```

### Making Changes

1. **Follow Coding Standards**:
    - See the [Coding Standards](#coding-standards) section below.
    - Use `snake_case` for function and method names.
    - Ensure compatibility with PHP 8.2+.

2. **Write Tests**:
    - Add or update tests in the `Tests/` directory, following the existing testing style using `php-repos/test-runner`.
    - Ensure all tests pass before submitting:
      ```bash
      phpkg build
      cd builds/development
      phpkg run https://github.com/php-repos/test-runner.git
      ```

3. **Update Documentation**:
    - Update `README.md` or other documentation for any changes to the public API.
    - Follow the existing documentation style with clear examples for path, file, directory, symlink, and JSON operations.

4. **Commit and Push**:
    - Write clear commit messages in the present tense (e.g., "Add recursive directory copy function").
    - Push your branch:
      ```bash
      git push origin feature/<your-feature-name>
      ```

### Submitting a Pull Request

1. **Create a Pull Request**:
    - Open a pull request from your branch to the `main` branch of `php-repos/file-manager`.
    - Include a descriptive title and details about your changes, referencing any relevant issues (e.g., "Fixes #123").

2. **Code Review**:
    - Respond to feedback and update your branch as needed.

3. **Continuous Integration**:
    - Ensure all CI checks pass. Fix any issues by updating your branch.

## Coding Standards

- **PHP Version**: Ensure compatibility with PHP 8.2+.
- **Naming Conventions**:
    - Use `snake_case` for function and method names (e.g., `realpath`, `preserve_copy`).
    - Use `PascalCase` for class names (e.g., `Path`, `Filename`).
- **Code Style**:
    - Use meaningful variable and function names.
    - Include PHPDoc blocks for all classes, methods, and functions, with descriptions, parameters, return types, and examples.
- **Testing**:
    - Write tests for all new functionality using `php-repos/test-runner`, matching the project's existing test style.
    - Ensure high test coverage for core features like path normalization, file operations, directory management, and symlink handling.
- **Documentation**:
    - Update `README.md` or other documentation for public API changes.
    - Provide clear, concise examples for path manipulation, file operations, directory operations, symlink handling, and JSON file operations.

## Reporting Bugs

Report bugs by opening an issue on the [GitHub Issues page](https://github.com/php-repos/file-manager/issues):

- Check for duplicates.
- Provide a clear title, description, steps to reproduce, PHP version, `phpkg` version, and any error messages.
- Use the `bug` label.

## Suggesting Features

Propose features by opening an issue with the `enhancement` label:

- Describe the feature, its benefits, and provide usage examples (e.g., new path manipulation or file operation functions).
- Be open to feedback and discussion.

## Community and Support

- For questions, use the [GitHub Discussions page](https://github.com/php-repos/file-manager/discussions).
- Watch the repository for updates and engage with the community through issues and discussions.

Thank you for helping improve the **FileManager** package!