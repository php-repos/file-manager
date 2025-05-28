<?php

namespace PhpRepos\FileManager\Symlinks;

use function unlink;

/**
 * Checks if a path is a symbolic link.
 *
 * @param string $path The path to check.
 * @return bool True if the path is a symbolic link, false otherwise.
 */
function exists(string $path): bool
{
    return is_link($path);
}

/**
 * Creates a symbolic link.
 *
 * @param string $source_path The target path the symlink will point to.
 * @param string $link_path The path where the symlink will be created.
 * @return bool True on success, false on failure.
 */
function link(string $source_path, string $link_path): bool
{
    return symlink($source_path, $link_path);
}

/**
 * Retrieves the target of a symbolic link.
 *
 * @param string $path The path to the symbolic link.
 * @return string The target path of the symbolic link, or false on failure.
 */
function target(string $path): string
{
    return readlink($path);
}

/**
 * Deletes a symbolic link.
 *
 * @param string $path The path to the symbolic link.
 * @return bool True on success, false on failure.
 */
function delete(string $path): bool
{
    return unlink($path);
}
