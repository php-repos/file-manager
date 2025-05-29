<?php

namespace PhpRepos\FileManager\Directories;

use DirectoryIterator;
use FilesystemIterator;
use PhpRepos\FileManager\Files;
use PhpRepos\FileManager\Symlinks;
use RecursiveCallbackFilterIterator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use function PhpRepos\FileManager\Paths\append;

/**
 * Changes the permissions of a directory.
 *
 * @param string $path The path to the directory.
 * @param int $permission The permission value (e.g., 0755).
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
 * Removes all contents from a directory.
 *
 * @param string $path The path to the directory.
 * @return void
 */
function clean(string $path): void
{
    $iterator = ls_all_backward($path);
    foreach ($iterator as $item) {
        is_dir($item) ? delete($item) : Files\delete($item);
    }
}

/**
 * Deletes an empty directory.
 *
 * @param string $path The path to the directory.
 * @return bool True on success, false on failure.
 */
function delete(string $path): bool
{
    return rmdir($path);
}

/**
 * Deletes a directory and all its contents recursively.
 *
 * @param string $path The path to the directory.
 * @return bool True on success, false on failure.
 */
function delete_recursive(string $path): bool
{
    clean($path);

    return delete($path);
}

/**
 * Checks if a directory exists.
 *
 * @param string $path The path to check.
 * @return bool True if the path is a directory, false otherwise.
 */
function exists(string $path): bool
{
    return file_exists($path) && is_dir($path);
}

/**
 * Checks if a directory exists or creates it.
 *
 * @param string $path The path to the directory.
 * @return bool True if the directory exists or was created, false on failure.
 */
function exists_or_create(string $path): bool
{
    return exists($path) || make($path);
}

/**
 * Checks if a directory is empty.
 *
 * @param string $path The path to the directory.
 * @return bool True if the directory is empty, false otherwise.
 */
function is_empty(string $path): bool
{
    $iterator = new DirectoryIterator($path);
    foreach ($iterator as $item) {
        if (!$item->isDot()) {
            return false;
        }
    }
    return true;
}

/**
 * Lists directory contents recursively, excluding hidden files.
 *
 * @param string $directory The path to the directory.
 * @return RecursiveIteratorIterator An iterator over the directory contents.
 */
function ls(string $directory): RecursiveIteratorIterator
{
    return ls_all($directory, function ($current) {
        return basename($current)[0] !== '.';
    });
}

/**
 * Lists all directory contents recursively with an optional filter.
 *
 * @param string $directory The path to the directory.
 * @param callable|null $filter An optional callback to filter paths.
 * @param int|null $mode The iteration mode (e.g., RecursiveIteratorIterator::SELF_FIRST).
 * @return RecursiveIteratorIterator An iterator over the directory contents.
 */
function ls_all(string $directory, ?callable $filter = null, ?int $mode = null): RecursiveIteratorIterator
{
    $mode = $mode ?: RecursiveIteratorIterator::SELF_FIRST;
    $iterator = new RecursiveDirectoryIterator(
        $directory,
        FilesystemIterator::SKIP_DOTS | FilesystemIterator::CURRENT_AS_PATHNAME
    );

    $iterator = is_callable($filter) ? new RecursiveCallbackFilterIterator($iterator, $filter) : $iterator;

    return new RecursiveIteratorIterator($iterator, $mode);
}

/**
 * Lists all directory contents recursively in reverse order (children first) with an optional filter.
 *
 * @param string $directory The path to the directory.
 * @param callable|null $filter An optional callback to filter paths.
 * @return RecursiveIteratorIterator An iterator over the directory contents, processing children before parents.
 */
function ls_all_backward(string $directory, ?callable $filter = null): RecursiveIteratorIterator
{
    return ls_all($directory, $filter, RecursiveIteratorIterator::CHILD_FIRST);
}

/**
 * Creates a directory with specified permissions.
 *
 * @param string $path The path to the directory.
 * @param int $permission The permission value (default: 0775).
 * @return bool True on success, false on failure.
 */
function make(string $path, int $permission = 0775): bool
{
    $old_umask = umask(0);
    $created = mkdir($path, $permission);
    umask($old_umask);

    return $created;
}

/**
 * Creates a directory and its parents with specified permissions.
 *
 * @param string $path The path to the directory.
 * @param int $permission The permission value (default: 0775).
 * @return bool True on success, false on failure.
 */
function make_recursive(string $path, int $permission = 0775): bool
{
    $old_umask = umask(0);
    $created = mkdir(directory: $path, permissions: $permission, recursive: true);
    umask($old_umask);

    return $created;
}

/**
 * Retrieves the permission bits of a directory.
 *
 * @param string $path The path to the directory.
 * @return int The permission bits (e.g., 0755), or false on failure.
 */
function permission(string $path): int
{
    clearstatcache();

    return fileperms($path) & 0x0FFF;
}

/**
 * Creates a directory with the same permissions as the source directory.
 *
 * @param string $origin The source directory path.
 * @param string $destination The destination directory path.
 * @return bool True on success, false on failure.
 */
function preserve_copy(string $origin, string $destination): bool
{
    return make($destination, permission($origin));
}

/**
 * Recursively copies a directory and its contents, preserving permissions.
 *
 * @param string $origin The source directory path.
 * @param string $destination The destination directory path.
 * @return bool True on success, false on failure.
 */
function preserve_copy_recursively(string $origin, string $destination): bool
{
    $created = make($destination, permission($origin));
    if (!$created) {
        return false;
    }

    foreach (ls_all($origin) as $item) {
        $relative = substr($item, strlen($origin) + 1);
        $destPath = append($destination, $relative);

        $created = (is_dir($item) && make($destPath, permission($item)))
            || (Symlinks\exists($item) && Symlinks\link(Symlinks\target($item), $destPath))
            || Files\preserve_copy($item, $destPath);

        if (!$created) {
            break;
        }
    }

    return $created;
}

/**
 * Cleans a directory if it exists, or creates it if it doesn't.
 *
 * @param string $path The path to the directory.
 * @return void
 */
function renew(string $path): void
{
    exists($path) ? clean($path) : make($path);
}

/**
 * Recursively cleans a directory if it exists, or creates it with parents if it doesn't.
 *
 * @param string $path The path to the directory.
 * @return void
 */
function renew_recursive(string $path): void
{
    exists($path) ? clean($path) : make_recursive($path);
}
