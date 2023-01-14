<?php

namespace Tests\Filesystem\Directory\FileTest;

use PhpRepos\FileManager\Filesystem\Directory;
use PhpRepos\FileManager\Filesystem\File;
use function PhpRepos\FileManager\Resolver\root;
use function PhpRepos\TestRunner\Assertions\Boolean\assert_true;
use function PhpRepos\TestRunner\Runner\test;

test(
    title: 'it should return file for the given directory',
    case: function () {
        $directory = Directory::from_string(root() . 'Tests/PlayGround');
        $result = $directory->file('filename');

        assert_true($result instanceof File);
        assert_true(
            Directory::from_string(root() . 'Tests/PlayGround')->append('filename')->string()
            ===
            $result->path->string()
        );

        return $directory;
    }
);
