<?php

namespace Tests\Filesystem\FilesystemCollection\FilesystemCollectionTest;

use PhpRepos\FileManager\Filesystem\Directory;
use PhpRepos\FileManager\Filesystem\File;
use PhpRepos\FileManager\Filesystem\FilesystemCollection;
use PhpRepos\FileManager\Filesystem\Symlink;
use function PhpRepos\TestRunner\Assertions\Boolean\assert_true;
use function PhpRepos\TestRunner\Runner\test;

test(
    title: 'it should accept Directory, File and Symlink objects',
    case: function () {
        $directory = Directory::from_string('/');
        $file = File::from_string('/file');
        $symlink = Symlink::from_string('/symlink');

        $collection = new FilesystemCollection([$directory, $file, $symlink]);

        assert_true([$directory, $file, $symlink] === $collection->items());
    }
);
