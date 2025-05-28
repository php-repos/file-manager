<?php

namespace PhpRepos\FileManager\Files;

use Generator;

/**
 * Changes the permissions of a file.
 *
 * @param string $path The path to the file.
 * @param int $permission The permission value (e.g., 0644).
 * @return bool True on success, false on failure.
 */
function chmod(string $path, int $permission): bool
{
    $old_umask = umask(0);
    $return = \chmod($path, $permission);
    umask($old_umask);

    return $return;
}

/**
 * Reads the entire content of a file.
 *
 * @param string $path The path to the file.
 * @return string The file content, or false on failure.
 */
function content(string $path): string
{
    return file_get_contents($path);
}

/**
 * Copies a file to a new location.
 *
 * @param string $origin The source file path.
 * @param string $destination The destination file path.
 * @return bool True on success, false on failure.
 */
function copy(string $origin, string $destination): bool
{
    return \copy($origin, $destination);
}

/**
 * Creates a new file with the specified content and permissions.
 *
 * @param string $path The path to the new file.
 * @param string $content The content to write to the file.
 * @param ?int $permission The permission value (e.g., 0664), or null to skip chmod.
 * @return bool True on success, false on failure.
 */
function create(string $path, string $content, ?int $permission = 0664): bool
{
    $file = fopen($path, "w");
    fwrite($file, $content);
    $created = fclose($file);
    chmod($path, $permission);

    return $created;
}

/**
 * Deletes a file.
 *
 * @param string $path The path to the file.
 * @return bool True on success, false on failure.
 */
function delete(string $path): bool
{
    return unlink($path);
}

/**
 * Checks if a file exists and is not a directory.
 *
 * @param string $path The path to check.
 * @return bool True if the path is a file, false otherwise.
 */
function exists(string $path): bool
{
    return file_exists($path) && ! is_dir($path);
}

/**
 * Yields lines from a file one at a time.
 *
 * @param string $path The path to the file.
 * @return Generator Yields each line as a string.
 */
function lines(string $path): Generator
{
    $fileHandler = @fopen($path, "r");

    while (($line = fgets($fileHandler)) !== false) {
        yield $line;
    }

    fclose($fileHandler);
}

/**
 * Writes or overwrites content to a file.
 *
 * @param string $path The path to the file.
 * @param string $content The content to write.
 * @return bool True on success, false on failure.
 */
function modify(string $path, string $content): bool
{
    return false !== file_put_contents($path, $content);
}

/**
 * Moves or renames a file.
 *
 * @param string $origin The source file path.
 * @param string $destination The destination file path.
 * @return bool True on success, false on failure.
 */
function move(string $origin, string $destination): bool
{
    return rename($origin, $destination);
}

/**
 * Retrieves the permission bits of a file.
 *
 * @param string $path The path to the file.
 * @return int The permission bits (e.g., 0644), or false on failure.
 */
function permission(string $path): int
{
    clearstatcache();
    return fileperms($path) & 0x0FFF;
}

/**
 * Copies a file and preserves its permissions.
 *
 * @param string $origin The source file path.
 * @param string $destination The destination file path.
 * @return bool True on success, false on failure.
 */
function preserve_copy(string $origin, string $destination): bool
{
    $copied = copy($origin, $destination);
    chmod($destination, permission($origin));
    return $copied;
}
