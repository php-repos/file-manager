<?php

namespace PhpRepos\FileManager\JsonFiles;

use JsonException;

/**
 * Reads a JSON file and converts its contents to a PHP array.
 *
 * @param string $path The path to the JSON file.
 * @return array The decoded JSON data as an associative array.
 * @throws JsonException If the JSON file is invalid or cannot be decoded.
 * @example
 * ```php
 * $data = to_array('/path/to/file.json');
 * // Example output: ['key' => 'value']
 * ```
 */
function to_array(string $path): array
{
    return json_decode(json: file_get_contents($path), associative: true, flags: JSON_THROW_ON_ERROR);
}

/**
 * Writes an array to a JSON file with pretty-printed formatting.
 *
 * @param string $path The path to the JSON file to write.
 * @param array $data The data to encode and write to the file.
 * @return bool True on success, false on failure.
 * @example
 * ```php
 * $data = ['key' => 'value'];
 * $success = write('/path/to/file.json', $data);
 * // Example output: true (and file.json contains pretty-printed JSON)
 * ```
 */
function write(string $path, array $data): bool
{
    return file_put_contents($path, json_encode($data, JSON_PRETTY_PRINT) . PHP_EOL) !== false;
}
