<?php

namespace PhpRepos\FileManager\Paths;

use PhpRepos\Datatype\Str;
use PhpRepos\Datatype\Text;

/**
 * Retrieves the current working directory with a trailing directory separator.
 *
 * @return string The absolute path to the current working directory, including a trailing directory separator.
 * @example
 * ```php
 * $root = root();
 * // Example output: "/var/www/html/"
 * ```
 */
function root(): string
{
    return getcwd() . DIRECTORY_SEPARATOR;
}

/**
 * Normalizes and resolves a path to its absolute form.
 *
 * This function processes a given path string by:
 * - Removing leading/trailing whitespace
 * - Normalizing directory separators
 * - Resolving double separators
 * - Handling '.' and '..' segments
 * - Removing trailing separator unless the path is the root directory
 *
 * @param string $path_string The path to normalize.
 * @return string The resolved absolute path.
 * @example
 * ```php
 * $path = realpath('/home/user/../docs/./file.txt');
 * // Example output: "/home/docs/file.txt"
 * ```
 */
function realpath(string $path_string): string
{
    $path_string = rtrim(ltrim($path_string));
    if ($path_string === '/') {
        return $path_string;
    }
    $needle = DIRECTORY_SEPARATOR === '/' ? '\\' : '/';
    $path_string = str_replace($needle, DIRECTORY_SEPARATOR, $path_string);

    while (str_contains($path_string, DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR)) {
        $path_string = str_replace(DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR, $path_string);
    }

    $path_string = str_replace(DIRECTORY_SEPARATOR . '.' . DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR, $path_string);
    $path_string = Str\last_character($path_string) === DIRECTORY_SEPARATOR ? Str\remove_last_character($path_string) : $path_string;

    $parts = explode(DIRECTORY_SEPARATOR, $path_string);

    while (in_array('..', $parts)) {
        foreach ($parts as $key => $part) {
            if ($part === '..') {
                unset($parts[$key - 1]);
                unset($parts[$key]);
                $parts = array_values($parts);
                break;
            }
        }
    }

    return implode(DIRECTORY_SEPARATOR, $parts);
}

/**
 * Appends one or more relative paths to a base path and normalizes the result.
 *
 * @param string $base The base path to append to.
 * @param string ...$relatives One or more relative paths to append.
 * @return string The normalized absolute path after appending the relative paths.
 * @example
 * ```php
 * $path = append('/home/user', 'docs', 'file.txt');
 * // Example output: "/home/user/docs/file.txt"
 * ```
 */
function append(string $base, string ...$relatives): string
{
    return realpath(Text::from($base)->concat(DIRECTORY_SEPARATOR, ...$relatives));
}

/**
 * Extracts the file extension from a path.
 *
 * @param string $path The path to extract the extension from.
 * @return string The file extension, or an empty string if none exists.
 * @example
 * ```php
 * $ext = extension('/home/user/file.txt');
 * // Example output: "txt"
 * ```
 */
function extension(string $path): string
{
    return pathinfo($path, PATHINFO_EXTENSION);
}

/**
 * Extracts the filename from a path.
 *
 * @param string $path The path to extract the filename from.
 * @return string The filename, or an empty string if the path is the root directory.
 * @example
 * ```php
 * $name = filename('/home/user/docs/file.txt');
 * // Example output: "file.txt"
 * ```
 */
function filename(string $path): string
{
    $path = realpath($path);
    return $path === DIRECTORY_SEPARATOR ? '' : Str\after_last_occurrence($path, DIRECTORY_SEPARATOR);
}

/**
 * Retrieves the parent directory of a given path.
 *
 * @param string $path The path to find the parent directory for.
 * @return string The parent directory path, or the root directory separator if the input is the root.
 * @example
 * ```php
 * $parent = parent('/home/user/docs/file.txt');
 * // Example output: "/home/user/docs"
 * ```
 */
function parent(string $path): string
{
    $path = realpath($path);

    if ($path === DIRECTORY_SEPARATOR) {
        return DIRECTORY_SEPARATOR;
    }

    $parent = realpath($path . '/..');

    return $parent === '' ? DIRECTORY_SEPARATOR : $parent;
}

/**
 * Constructs a path to a sibling file or directory.
 *
 * @param string $path The reference path to find the sibling for.
 * @param string $filename The name of the sibling file or directory.
 * @return string The normalized path to the sibling file or directory.
 * @example
 * ```php
 * $sibling = sibling('/home/user/docs/file.txt', 'other_file.txt');
 * // Example output: "/home/user/docs/other_file.txt"
 * ```
 */
function sibling(string $path, string $filename): string
{
    return append(parent($path), $filename);
}

/**
 * Calculates the relative path from an origin to a destination path.
 *
 * @param string $origin The starting path.
 * @param string $destination The target path.
 * @return string The relative path from origin to destination, or '.' if they are the same.
 * @example
 * ```php
 * $relative = relative_path('/home/user/docs', '/home/user/images/photo.jpg');
 * // Example output: "../images/photo.jpg"
 * ```
 */
function relative_path(string $origin, string $destination): string
{
    $origin = realpath($origin);
    $destination = realpath($destination);

    if ($origin === $destination) {
        return '';
    }

    $origin_parts = array_filter(explode(DIRECTORY_SEPARATOR, $origin), fn($part) => $part !== '');
    $destination_parts = array_filter(explode(DIRECTORY_SEPARATOR, $destination), fn($part) => $part !== '');

    if (empty($origin_parts)) {
        return implode(DIRECTORY_SEPARATOR, $destination_parts);
    }

    $common_length = 0;
    foreach ($origin_parts as $i => $part) {
        if (!isset($destination_parts[$i]) || $part !== $destination_parts[$i]) {
            break;
        }
        $common_length++;
    }

    $upward_steps = count($origin_parts) - $common_length;
    $relative_parts = array_fill(0, $upward_steps, '..');
    $relative_parts = array_merge($relative_parts, array_slice($destination_parts, $common_length));

    return implode(DIRECTORY_SEPARATOR, $relative_parts) ?: '.';
}

/**
 * Relocates a path by replacing the first occurrence of an origin segment with a destination segment.
 *
 * @param string $path The original path to modify.
 * @param string $origin The segment to replace in the path.
 * @param string $destination The segment to replace with.
 * @return string The normalized path after replacement.
 * @example
 * ```php
 * $new_path = relocate('/home/user/docs/file.txt', 'docs', 'images');
 * // Example output: "/home/user/images/file.txt"
 * ```
 */
function relocate(string $path, string $origin, string $destination): string
{
    return realpath(Str\replace_first_occurrence($path, $origin, $destination));
}
