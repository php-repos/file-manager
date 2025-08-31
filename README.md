# PhpRepos/FileManager

A comprehensive PHP library for simplified file system operations, providing utilities for handling paths, files, directories, symbolic links, and JSON files. Built with modern PHP 8.2+ features and designed for developer productivity.

## 📋 Table of Contents

- [Installation](#installation)
- [Quick Start](#quick-start)
- [API Reference](#api-reference)
  - [Paths Namespace](#paths-namespace)
  - [Path Class](#path-class)
  - [Filename Class](#filename-class)
  - [Files Namespace](#files-namespace)
  - [Directories Namespace](#directories-namespace)
  - [JsonFiles Namespace](#jsonfiles-namespace)
  - [Symlinks Namespace](#symlinks-namespace)
- [Advanced Usage](#advanced-usage)
- [Contributing](#contributing)
- [License](#license)

## 🚀 Installation

Install the library using the `phpkg` package manager:

```bash
phpkg add https://github.com/php-repos/file-manager.git
```

**Requirements:** PHP 8.2 or higher

## ⚡ Quick Start

```php
use PhpRepos\FileManager\Paths;
use PhpRepos\FileManager\Files;
use PhpRepos\FileManager\Directories;

// Create a directory and file
Directories\make('/path/to/dir', 0755);
Files\create('/path/to/dir/file.txt', 'Hello World!');

// List directory contents
$files = Directories\ls('/path/to/dir'); // Non-recursive, excludes hidden files
$all_files = Directories\ls_all('/path/to/dir'); // Non-recursive, includes hidden files

// Read file content
$content = Files\content('/path/to/dir/file.txt');
```

## 📚 API Reference

### Paths Namespace

The `PhpRepos\FileManager\Paths` namespace provides functional utilities for path manipulation and normalization.

#### `root(): string`
Returns the current working directory with a trailing separator.

```php
$root = Paths\root();
// Output: "/var/www/html/"
```

#### `realpath(string $path_string): string`
Normalizes and resolves a path to its absolute form, handling `.`, `..`, and directory separators.

```php
$path = Paths\realpath('/home/user/../docs/./file.txt');
// Output: "/home/docs/file.txt"

$path = Paths\realpath('C:\\Users\\User\\..\\Documents\\.\\file.txt');
// Output: "C:/Users/Documents/file.txt"
```

#### `append(string $base, string ...$relatives): string`
Appends one or more relative paths to a base path and normalizes the result.

```php
$path = Paths\append('/home/user', 'docs', 'file.txt');
// Output: "/home/user/docs/file.txt"

$path = Paths\append('/var/www', 'public', 'css', 'style.css');
// Output: "/var/www/public/css/style.css"
```

#### `extension(string $path): string`
Extracts the file extension from a path.

```php
$ext = Paths\extension('/home/user/file.txt');
// Output: "txt"

$ext = Paths\extension('/home/user/file');
// Output: ""
```

#### `filename(string $path): string`
Extracts the filename from a path.

```php
$name = Paths\filename('/home/user/docs/file.txt');
// Output: "file.txt"

$name = Paths\filename('/home/user/docs/');
// Output: ""
```

#### `parent(string $path): string`
Retrieves the parent directory of a given path.

```php
$parent = Paths\parent('/home/user/docs/file.txt');
// Output: "/home/user/docs"

$parent = Paths\parent('/home/user/docs/');
// Output: "/home/user"
```

#### `sibling(string $path, string $filename): string`
Constructs a path to a sibling file or directory.

```php
$sibling = Paths\sibling('/home/user/docs/file.txt', 'other_file.txt');
// Output: "/home/user/docs/other_file.txt"
```

#### `relative_path(string $origin, string $destination): string`
Calculates the relative path from an origin to a destination path.

```php
$relative = Paths\relative_path('/home/user/docs', '/home/user/images/photo.jpg');
// Output: "../images/photo.jpg"

$relative = Paths\relative_path('/home/user/docs', '/home/user/docs/file.txt');
// Output: "file.txt"
```

#### `relocate(string $path, string $origin, string $destination): string`
Relocates a path by replacing the first occurrence of an origin segment with a destination segment.

```php
$new_path = Paths\relocate('/home/user/docs/file.txt', 'docs', 'images');
// Output: "/home/user/images/file.txt"
```

### Path Class

The `PhpRepos\FileManager\Path` class provides object-oriented path handling, extending the `Text` datatype.

#### `Path::from_string(string $path_string): static`
Creates a new Path instance from a string, normalizing it to an absolute path.

```php
use PhpRepos\FileManager\Path;

$path = Path::from_string('/home/user/../docs');
// Output: Path object with string "/home/docs"
```

#### `sub(Filename|string ...$path): static`
Appends one or more path segments to the current path and normalizes the result.

```php
$path = Path::from_string('/home/user');
$path->sub('docs', 'file.txt');
// Output: Path object with string "/home/user/docs/file.txt"
```

#### `relocate(string $origin, string $destination): Path`
Relocates the path by replacing the first occurrence of an origin segment with a destination segment.

```php
$path = Path::from_string('/home/user/docs/file.txt');
$path->relocate('docs', 'images');
// Output: Path object with string "/home/user/images/file.txt"
```

### Filename Class

The `PhpRepos\FileManager\Filename` class provides type-safe filename management.

```php
use PhpRepos\FileManager\Filename;

$filename = new Filename('document.txt');
// Output: Filename object with string "document.txt"

// Can be used with Path operations
$path = Path::from_string('/home/user')->sub($filename);
```

### Files Namespace

The `PhpRepos\FileManager\Files` namespace provides comprehensive file operations.

#### `chmod(string $path, int $permission): bool`
Changes the permissions of a file.

```php
$success = Files\chmod('/path/to/file.txt', 0644);
```

#### `content(string $path): string`
Reads the entire content of a file.

```php
$content = Files\content('/path/to/file.txt');
// Output: File content as string
```

#### `copy(string $origin, string $destination): bool`
Copies a file to a new location.

```php
$success = Files\copy('/source/file.txt', '/dest/file.txt');
```

#### `create(string $path, string $content, ?int $permission = 0664): bool`
Creates a new file with the specified content and permissions.

```php
$success = Files\create('/path/to/file.txt', 'Hello, World!', 0644);
```

#### `delete(string $path): bool`
Deletes a file.

```php
$success = Files\delete('/path/to/file.txt');
```

#### `exists(string $path): bool`
Checks if a file exists and is not a directory.

```php
if (Files\exists('/path/to/file.txt')) {
    // File exists and is not a directory
}
```

#### `lines(string $path): Generator`
Yields lines from a file one at a time, memory-efficient for large files.

```php
foreach (Files\lines('/path/to/file.txt') as $line) {
    echo $line; // Process each line
}
```

#### `modify(string $path, string $content): bool`
Writes or overwrites content to a file.

```php
$success = Files\modify('/path/to/file.txt', 'New content');
```

#### `move(string $origin, string $destination): bool`
Moves or renames a file.

```php
$success = Files\move('/old/path/file.txt', '/new/path/file.txt');
```

#### `permission(string $path): int`
Retrieves the permission bits of a file.

```php
$perms = Files\permission('/path/to/file.txt');
// Output: Permission bits (e.g., 0644)
```

#### `preserve_copy(string $origin, string $destination): bool`
Copies a file and preserves its permissions.

```php
$success = Files\preserve_copy('/source/file.txt', '/dest/file.txt');
// Destination file will have same permissions as source
```

### Directories Namespace

The `PhpRepos\FileManager\Directories` namespace provides comprehensive directory management operations.

#### `chmod(string $path, int $permission): bool`
Changes the permissions of a directory.

```php
$success = Directories\chmod('/path/to/dir', 0755);
```

#### `clean(string $path): void`
Removes all contents from a directory.

```php
Directories\clean('/path/to/dir');
// Directory is now empty but still exists
```

#### `delete(string $path): bool`
Deletes an empty directory.

```php
$success = Directories\delete('/path/to/empty_dir');
```

#### `delete_recursive(string $path): bool`
Deletes a directory and all its contents recursively.

```php
$success = Directories\delete_recursive('/path/to/dir');
// Removes directory and all subdirectories/files
```

#### `exists(string $path): bool`
Checks if a directory exists.

```php
if (Directories\exists('/path/to/dir')) {
    // Directory exists
}
```

#### `exists_or_create(string $path): bool`
Checks if a directory exists or creates it.

```php
$success = Directories\exists_or_create('/path/to/dir');
// Creates directory if it doesn't exist
```

#### `is_empty(string $path): bool`
Checks if a directory is empty.

```php
if (Directories\is_empty('/path/to/dir')) {
    // Directory contains no files or subdirectories
}
```

#### `make(string $path, int $permission = 0775): bool`
Creates a directory with specified permissions.

```php
$success = Directories\make('/path/to/new_dir', 0755);
```

#### `make_recursive(string $path, int $permission = 0775): bool`
Creates a directory and its parents with specified permissions.

```php
$success = Directories\make_recursive('/path/to/nested/dir', 0755);
// Creates all parent directories as needed
```

#### `permission(string $path): int`
Retrieves the permission bits of a directory.

```php
$perms = Directories\permission('/path/to/dir');
// Output: Permission bits (e.g., 0755)
```

#### `preserve_copy(string $origin, string $destination): bool`
Creates a directory with the same permissions as the source directory.

```php
$success = Directories\preserve_copy('/source/dir', '/dest/dir');
```

#### `preserve_copy_recursively(string $origin, string $destination): bool`
Recursively copies a directory and its contents, preserving permissions.

```php
$success = Directories\preserve_copy_recursively('/source/dir', '/dest/dir');
// Copies entire directory tree with preserved permissions
```

#### `renew(string $path): void`
Cleans a directory if it exists, or creates it if it doesn't.

```php
Directories\renew('/path/to/dir');
// If exists: cleans it; if not: creates it
```

#### `renew_recursive(string $path): void`
Recursively cleans a directory if it exists, or creates it with parents if it doesn't.

```php
Directories\renew_recursive('/path/to/nested/dir');
// If exists: cleans it; if not: creates with parents
```

#### Directory Listing Functions

##### `ls(string $directory): array`
Lists directory contents (non-recursive), excluding hidden files (like `ls` command).

```php
$files = Directories\ls('/path/to/dir');
// Returns array of non-hidden files/directories (non-recursive)
// Output: ['/path/to/dir/file1.txt', '/path/to/dir/subdir']
```

##### `ls_all(string $directory, ?callable $filter = null): array`
Lists all directory contents (non-recursive), including hidden files (like `ls -a` command).

```php
$all_files = Directories\ls_all('/path/to/dir');
// Returns array of all files/directories including hidden ones (non-recursive)
// Output: ['/path/to/dir/.hidden', '/path/to/dir/file1.txt', '/path/to/dir/subdir']

// With custom filter
$filtered = Directories\ls_all('/path/to/dir', function($path) {
    return str_contains($path, '.txt');
});
```

##### `ls_recursively(string $directory, ?int $mode = null): RecursiveIteratorIterator`
Lists directory contents recursively, excluding hidden files.

```php
$iterator = Directories\ls_recursively('/path/to/dir');
foreach ($iterator as $item) {
    echo $item; // All files/directories recursively (excluding hidden)
}
```

##### `ls_all_recursively(string $directory, ?callable $filter = null, ?int $mode = null): RecursiveIteratorIterator`
Lists all directory contents recursively, including hidden files.

```php
$iterator = Directories\ls_all_recursively('/path/to/dir');
foreach ($iterator as $item) {
    echo $item; // All files/directories recursively (including hidden)
}

// With custom filter and mode
$iterator = Directories\ls_all_recursively('/path/to/dir', null, RecursiveIteratorIterator::CHILD_FIRST);
```

##### `ls_all_backward(string $directory, ?callable $filter = null): RecursiveIteratorIterator`
Lists all directory contents recursively in reverse order (children first).

```php
$iterator = Directories\ls_all_backward('/path/to/dir');
// Useful for cleanup operations where you need to process children before parents
```

### JsonFiles Namespace

The `PhpRepos\FileManager\JsonFiles` namespace provides utilities for JSON file operations.

#### `to_array(string $path): array`
Reads a JSON file and converts its contents to a PHP array.

```php
$data = JsonFiles\to_array('/path/to/file.json');
// Output: ['key' => 'value']

// Throws JsonException if JSON is invalid
```

#### `write(string $path, array $data): bool`
Writes an array to a JSON file with pretty-printed formatting.

```php
$data = ['name' => 'John', 'age' => 30];
$success = JsonFiles\write('/path/to/file.json', $data);
// Creates file.json with pretty-printed JSON and trailing newline
```

### Symlinks Namespace

The `PhpRepos\FileManager\Symlinks` namespace manages symbolic links.

#### `exists(string $path): bool`
Checks if a path is a symbolic link.

```php
if (Symlinks\exists('/path/to/link')) {
    // Path is a symbolic link
}
```

#### `link(string $source_path, string $link_path): bool`
Creates a symbolic link.

```php
$success = Symlinks\link('/path/to/target', '/path/to/link');
// Creates symbolic link at /path/to/link pointing to /path/to/target
```

#### `target(string $path): string`
Retrieves the target of a symbolic link.

```php
$target = Symlinks\target('/path/to/link');
// Output: "/path/to/target"
```

#### `delete(string $path): bool`
Deletes a symbolic link.

```php
$success = Symlinks\delete('/path/to/link');
// Removes the symbolic link (not the target)
```

## 🔧 Advanced Usage

### Working with Iterators

The recursive directory functions return `RecursiveIteratorIterator` objects that can be used for advanced operations:

```php
// Get all PHP files recursively
$iterator = Directories\ls_all_recursively('/path/to/project', function($path) {
    return str_ends_with($path, '.php');
});

foreach ($iterator as $phpFile) {
    echo "PHP file: $phpFile\n";
}

// Process in reverse order (useful for cleanup)
$iterator = Directories\ls_all_backward('/path/to/dir');
foreach ($iterator as $item) {
    // Process children before parents
    if (is_dir($item)) {
        Directories\delete($item);
    } else {
        Files\delete($item);
    }
}
```

### Permission Handling

The library provides consistent permission handling across all operations:

```php
// Create directory with specific permissions
Directories\make('/path/to/dir', 0755);

// Copy file preserving permissions
Files\preserve_copy('/source/file.txt', '/dest/file.txt');

// Copy directory tree preserving all permissions
Directories\preserve_copy_recursively('/source/dir', '/dest/dir');
```

### Error Handling

The library uses PHP's built-in error handling and returns boolean values for operations that can fail:

```php
// Check if operations succeeded
if (!Directories\make('/path/to/dir')) {
    // Handle directory creation failure
}

if (!Files\create('/path/to/file.txt', 'content')) {
    // Handle file creation failure
}

// JSON operations throw JsonException for invalid JSON
try {
    $data = JsonFiles\to_array('/path/to/invalid.json');
} catch (JsonException $e) {
    // Handle JSON parsing error
}
```

### Cross-Platform Compatibility

The library handles cross-platform path separators automatically:

```php
// Works on both Windows and Unix-like systems
$path = Paths\realpath('C:\\Users\\User\\..\\Documents\\.\\file.txt');
// Output: "C:/Users/Documents/file.txt" (normalized)

$path = Paths\append('/home/user', 'docs', 'file.txt');
// Output: "/home/user/docs/file.txt"
```

## 🤝 Contributing

Contributions are welcome! Please submit issues or pull requests to the [GitHub repository](https://github.com/php-repos/file-manager).

### Development Setup

1. Clone the repository
2. Install dependencies with `phpkg install`
3. Run tests with `phpkg run https://github.com/php-repos/test-runner.git run`
4. Submit your changes

## 📄 License

This library is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.

## 🆘 Support

- **GitHub Issues**: [Report bugs or request features](https://github.com/php-repos/file-manager/issues)
- **Documentation**: This README and inline code documentation
- **Tests**: Comprehensive test suite demonstrating all functionality

---

**Built with ❤️ by the PhpRepos team**