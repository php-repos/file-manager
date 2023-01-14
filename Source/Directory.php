<?php

namespace PhpRepos\FileManager\Directory;

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

function ls(string $path): array
{
    $list = scandir($path);

    return array_values(array_filter($list, fn ($item) => ! str_starts_with($item, '.')));
}

function ls_all(string $path): array
{
    $list = scandir($path);

    return array_values(array_filter($list, fn ($item) => ! in_array($item, ['.', '..'])));
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
    $result = true;

    foreach (ls_all($origin) as $item) {
        if (! $result) {
            break;
        }

        $origin_item = $origin . DIRECTORY_SEPARATOR . $item;
        $destination_item = $destination . DIRECTORY_SEPARATOR . $item;

        $result = is_dir($origin_item)
            ? (preserve_copy($origin_item, $destination_item) && preserve_copy_recursively($origin_item, $destination_item))
            : preserve_copy_file($origin_item, $destination_item);
    }

    return $result;
}

function renew(string $path): void
{
    exists($path) ? clean($path) : make($path);
}

function renew_recursive(string $path): void
{
    exists($path) ? clean($path) : make_recursive($path);
}
