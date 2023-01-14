<?php

namespace PhpRepos\FileManager;

use InvalidArgumentException;
use PhpRepos\Datatype\Text;
use PhpRepos\FileManager\Filesystem\Address;
use PhpRepos\FileManager\Filesystem\Directory;
use PhpRepos\FileManager\Filesystem\File;
use PhpRepos\FileManager\Filesystem\Symlink;
use function PhpRepos\Datatype\Str\starts_with_regex;

class Path extends Text
{
    use Address;

    public function __construct(?string $init = null)
    {
        if (! $this->is_valid($init)) {
            throw new InvalidArgumentException('Invalid string passed to path.');
        }

        parent::__construct($init);
    }

    public static function from_string(string $path_string): static
    {
        return new static(Resolver\realpath($path_string));
    }

    public function append(string $path): Path
    {
        return Path::from_string($this . DIRECTORY_SEPARATOR . $path);
    }

    public function as_file(): File
    {
        return new File($this);
    }

    public function as_directory(): Directory
    {
        return new Directory($this);
    }

    public function as_symlink(): Symlink
    {
        return new Symlink($this);
    }

    public function is_valid(string $string): bool
    {
        return strlen($string) > 0 && (str_starts_with($string, '/') || starts_with_regex($string, '[A-Za-z]:\\'));
    }
}
