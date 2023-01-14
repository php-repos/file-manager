<?php

namespace PhpRepos\FileManager\Filesystem;

use Generator;
use PhpRepos\FileManager\Path;
use Stringable;
use function PhpRepos\FileManager\File\chmod;
use function PhpRepos\FileManager\File\content;
use function PhpRepos\FileManager\File\create;
use function PhpRepos\FileManager\File\delete;
use function PhpRepos\FileManager\File\exists;
use function PhpRepos\FileManager\File\lines;
use function PhpRepos\FileManager\File\modify;
use function PhpRepos\FileManager\File\permission;
use function PhpRepos\FileManager\File\preserve_copy;

class File implements Stringable
{
    use Address;

    public function __construct(public Path $path) {}

    public static function from_string(string $path_string): static
    {
        return new static(Path::from_string($path_string));
    }

    public function __toString(): string
    {
        return $this->path->string();
    }

    public function chmod(int $permission): self
    {
        chmod($this->path, $permission);

        return $this;
    }

    public function content(): string
    {
        return content($this->path);
    }

    public function create(string $content, int $permission = 0664): self
    {
        create($this->path, $content, $permission);

        return $this;
    }

    public function delete(): self
    {
        delete($this->path);

        return $this;
    }

    public function exists(): bool
    {
        return exists($this->path);
    }

    public function lines(): Generator
    {
        return lines($this->path);
    }

    public function modify(string $content): self
    {
        modify($this->path, $content);

        return $this;
    }

    public function permission(): int
    {
        return permission($this->path);
    }

    public function preserve_copy(File $destination): self
    {
        preserve_copy($this->path, $destination->path);

        return $this;
    }
}
