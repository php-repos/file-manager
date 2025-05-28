# PhpRepos/FileManager

A lightweight PHP library for simplified file system operations, providing utilities for handling paths, files, directories, symbolic links, and JSON files.

## Installation

Install the library using the `phpkg` package manager:

```bash
phpkg add https://github.com/php-repos/file-manager.git
```

Ensure your project uses PHP 8.2 or higher, as the library leverages modern PHP features.

## Overview

The `PhpRepos\FileManager` library offers a clean and intuitive API for common file system tasks, including:

- **Path Management**: Normalize and manipulate file system paths.
- **File Operations**: Read, write, copy, move, and delete files with permission handling.
- **Directory Operations**: Create, delete, and iterate over directories with recursive options.
- **Symbolic Links**: Create, check, and manage symlinks.
- **JSON File Handling**: Read and write JSON files with ease.

The library is organized into several namespaces:

- `PhpRepos\FileManager\Paths`: Functions for path normalization and manipulation.
- `PhpRepos\FileManager\Path`: A class for object-oriented path handling.
- `PhpRepos\FileManager\Filename`: A class for type-safe filename management.
- `PhpRepos\FileManager\JsonFiles`: Utilities for JSON file operations.
- `PhpRepos\FileManager\Directories`: Functions for directory management.
- `PhpRepos\FileManager\Files`: Functions for file operations.
- `PhpRepos\FileManager\Symlinks`: Functions for symbolic link operations.

## Usage Examples

Below are examples demonstrating key features of the library.

### Path Manipulation

The `Paths` namespace and `Path` class provide tools for path normalization and manipulation.

```php
use PhpRepos\FileManager\Paths;
use PhpRepos\FileManager\Path;

$path = Paths\realpath('/home/user/../docs/./file.txt');
// Output: "/home/docs/file.txt"

$path_obj = Path::from_string('/home/user')->sub('docs', 'file.txt');
// Output: Path object with string "/home/user/docs/file.txt"

$new_path = $path_obj->relocate('docs', 'images');
// Output: Path object with string "/home/user/images/file.txt"
```

### Filename Handling

The `Filename` class ensures type-safe filename management.

```php
use PhpRepos\FileManager\Filename;

$filename = new Filename('document.txt');
// Output: Filename object with string "document.txt"
```

### JSON File Operations

The `JsonFiles` namespace simplifies reading and writing JSON files.

```php
use PhpRepos\FileManager\JsonFiles;

$data = ['key' => 'value'];
JsonFiles\write('/path/to/file.json', $data);
// Creates file.json with pretty-printed JSON

$read_data = JsonFiles\to_array('/path/to/file.json');
// Output: ['key' => 'value']
```

### Directory Operations

The `Directories` namespace provides functions for managing directories.

```php
use PhpRepos\FileManager\Directories;

Directories\make('/path/to/new_dir', 0755);
// Creates a directory with 0755 permissions

Directories\clean('/path/to/dir');
// Removes all contents from the directory

foreach (Directories\ls('/path/to/dir') as $item) {
    echo $item . PHP_EOL; // Lists non-hidden directory contents recursively
}

Directories\preserve_copy_recursively('/source/dir', '/dest/dir');
// Copies directory and contents, preserving permissions
```

### File Operations

The `Files` namespace handles file-specific tasks.

```php
use PhpRepos\FileManager\Files;

Files\create('/path/to/file.txt', 'Hello, World!', 0644);
// Creates file with content and 0644 permissions

$content = Files\content('/path/to/file.txt');
// Output: "Hello, World!"

Files\preserve_copy('/source/file.txt', '/dest/file.txt');
// Copies file, preserving permissions

foreach (Files\lines('/path/to/file.txt') as $line) {
    echo $line; // Yields each line of the file
}
```

### Symbolic Link Operations

The `Symlinks` namespace manages symbolic links.

```php
use PhpRepos\FileManager\Symlinks;

Symlinks\link('/path/to/target', '/path/to/link');
// Creates a symbolic link

$target = Symlinks\target('/path/to/link');
// Output: "/path/to/target"

Symlinks\delete('/path/to/link');
// Removes the symbolic link
```

## Contributing

Contributions are welcome! Please submit issues or pull requests to the [GitHub repository](https://github.com/php-repos/file-manager).

## License

This library is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.