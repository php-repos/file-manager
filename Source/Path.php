<?php

namespace PhpRepos\FileManager;

use PhpRepos\Datatype\Text;
use function PhpRepos\FileManager\Paths\append;
use function PhpRepos\FileManager\Paths\realpath;
use function PhpRepos\FileManager\Paths\relocate;

/**
 * A class for handling file system paths, extending the Text datatype.
 *
 * This class provides methods to manipulate and normalize file system paths,
 * ensuring consistent path handling with support for appending and relocating path segments.
 */
class Path extends Text
{
    /**
     * Creates a new Path instance from a string, normalizing it to an absolute path.
     *
     * @param string $path_string The path string to normalize.
     * @return static A new Path instance with the normalized path.
     * @example
     * ```php
     * $path = Path::from_string('/home/user/../docs');
     * // Example output: Path object with string "/home/docs"
     * ```
     */
    public static function from_string(string $path_string): static
    {
        return new static(realpath($path_string));
    }

    /**
     * Appends one or more path segments to the current path and normalizes the result.
     *
     * @param Filename|string ...$path One or more path segments or Filename objects to append.
     * @return static The current Path instance with the updated path.
     * @example
     * ```php
     * $path = Path::from_string('/home/user');
     * $path->sub('docs', 'file.txt');
     * // Example output: Path object with string "/home/user/docs/file.txt"
     * ```
     */
    public function sub(Filename|string ...$path): static
    {
        $this->string = append($this, ...$path);

        return $this;
    }

    /**
     * Relocates the path by replacing the first occurrence of an origin segment with a destination segment.
     *
     * @param string $origin The segment to replace in the path.
     * @param string $destination The segment to replace with.
     * @return Path The current Path instance with the updated path.
     * @example
     * ```php
     * $path = Path::from_string('/home/user/docs/file.txt');
     * $path->relocate('docs', 'images');
     * // Example output: Path object with string "/home/user/images/file.txt"
     * ```
     */
    public function relocate(string $origin, string $destination): Path
    {
        $this->string = relocate($this, $origin, $destination);

        return $this;
    }
}
