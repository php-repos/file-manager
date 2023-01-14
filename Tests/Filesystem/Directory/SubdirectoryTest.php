<?php

namespace Tests\Filesystem\Directory\SubdirectoryTest;

use PhpRepos\FileManager\Filesystem\Directory;
use function PhpRepos\FileManager\Resolver\root;
use function PhpRepos\TestRunner\Assertions\Boolean\assert_true;
use function PhpRepos\TestRunner\Runner\test;

test(
    title: 'it should return subdirectory for the given directory',
    case: function () {
        $directory = Directory::from_string(root() . 'Tests/PlayGround');
        $result = $directory->subdirectory('Subdirectory');

        assert_true($result instanceof Directory);
        assert_true(
            Directory::from_string(root() . 'Tests/PlayGround')->append('Subdirectory')->string()
            ===
            $result->path->string()
        );

        return $directory;
    }
);
