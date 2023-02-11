<?php

namespace PhpRepos\FileManager\Directory;

use PhpRepos\FileManager\FilesystemCollection;
use PhpRepos\FileManager\FilesystemTree;
use PhpRepos\FileManager\Path;
use function PhpRepos\FileManager\File\preserve_copy as preserve_copy_file;

function chmod(string $path, int $permission): bool
{
    $old_umask = umask(0);
    $return = \chmod($path, $permission);
    umask($old_umask);

    return $return;
}

function clean(string $path): void
{
    $dir = opendir($path);

    while (false !== ($file = readdir($dir))) {
        if (! in_array($file, ['.', '..'])) {
            $path_to_file = $path . DIRECTORY_SEPARATOR . $file;
            is_dir($path_to_file) ? delete_recursive($path_to_file) : unlink($path_to_file);
        }
    }

    closedir($dir);
}

function delete(string $path): bool
{
    return rmdir($path);
}

function delete_recursive(string $path): bool
{
    clean($path);

    return delete($path);
}

function exists(string $path): bool
{
    return file_exists($path) && is_dir($path);
}

function exists_or_create(string $path): bool
{
    return exists($path) || make($path);
}

function is_empty(string $path): bool
{
    return scandir($path) == ['.', '..'];
}

function ls(string $path): FilesystemCollection
{
    $path = Path::from_string($path);

    return array_reduce(
        array_values(array_filter(scandir($path), fn ($item) => ! str_starts_with($item, '.'))),
        fn (FilesystemCollection $collection, string $item) => $collection->put($path->append($item)),
        new FilesystemCollection()
    );
}

function ls_all(string $path): FilesystemCollection
{
    $path = Path::from_string($path);

    return array_reduce(
        array_values(array_filter(scandir($path), fn ($item) => ! in_array($item, ['.', '..']))),
        fn (FilesystemCollection $collection, string $item) => $collection->put($path->append($item)),
        new FilesystemCollection()
    );
}

function ls_recursively(string $path): FilesystemTree
{
    $path = Path::from_string($path);

    $tree = new FilesystemTree($path);

    $add_leaves = function (Path $vertex) use ($tree, &$add_leaves) {
        ls_all($vertex)
            ->each(function (Path $object) use ($tree, &$vertex, &$add_leaves) {
                $tree->edge($vertex, $object);
                if (is_dir($object)) {
                    $add_leaves($object);
                }
            });
    };

    $add_leaves($path);

    return $tree;
}

function make(string $path, int $permission = 0775): bool
{
    $old_umask = umask(0);
    $created = mkdir($path, $permission);
    umask($old_umask);

    return $created;
}

function make_recursive(string $path, int $permission = 0775): bool
{
    $old_umask = umask(0);
    $created = mkdir(directory: $path, permissions: $permission, recursive: true);
    umask($old_umask);

    return $created;
}

function permission(string $path): int
{
    clearstatcache();

    return fileperms($path) & 0x0FFF;
}

function preserve_copy(string $origin, string $destination): bool
{
    return make($destination, permission($origin));
}

function preserve_copy_recursively(string $origin, string $destination): bool
{
    return ls_all($origin)
        ->reduce(function (bool $carry, Path $path) use ($origin, $destination) {
            return $carry && is_dir($path)
                ? (preserve_copy($path, $path->relocate($origin, $destination)) && preserve_copy_recursively($path, $path->relocate($origin, $destination)))
                : preserve_copy_file($path, $path->relocate($origin, $destination));
        }, true);
}

function renew(string $path): void
{
    exists($path) ? clean($path) : make($path);
}

function renew_recursive(string $path): void
{
    exists($path) ? clean($path) : make_recursive($path);
}
