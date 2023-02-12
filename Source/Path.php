<?php

namespace PhpRepos\FileManager;

use PhpRepos\Datatype\Text;
use PhpRepos\Datatype\Str;

class Path extends Text
{
    public function __construct(string $init)
    {
        parent::__construct($init);
    }

    public static function from_string(string $path_string): static
    {
        return new static(Resolver\realpath($path_string));
    }

    public function append(Filename|string $path): Path
    {
        return Path::from_string($this . DIRECTORY_SEPARATOR . $path);
    }

    public function leaf(): Filename
    {
        if (strlen($this) === 1) {
            return new Filename($this);
        }

        $leaf = Str\after_last_occurrence($this, DIRECTORY_SEPARATOR);

        return new Filename($leaf ?? $this);
    }

    public function parent(): static
    {
        return static::from_string(Str\before_last_occurrence($this, DIRECTORY_SEPARATOR));
    }

    public function relocate(string $origin, string $destination): Path
    {
        $path = Str\replace_first_occurrence($this, $origin, $destination);

        return Path::from_string($path);
    }

    public function sibling(string $path): Path
    {
        return new Path($this->parent()->append($path)->string());
    }
}
