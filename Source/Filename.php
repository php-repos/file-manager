<?php

namespace PhpRepos\FileManager;

use PhpRepos\Datatype\Text;

/**
 * A class for handling filenames, extending the Text datatype.
 *
 * This class encapsulates a filename as a string, providing a type-safe way to
 * work with filenames in file system operations.
 */
class Filename extends Text
{
    /**
     * Constructs a new Filename instance from a string.
     *
     * @param string $init The filename string to initialize the instance with.
     * @example
     * ```php
     * $filename = new Filename('document.txt');
     * // Example output: Filename object with string "document.txt"
     * ```
     */
    public function __construct(string $init)
    {
        parent::__construct($init);
    }
}
