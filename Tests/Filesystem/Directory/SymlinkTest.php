<?php

namespace Tests\Filesystem\Directory\SymlinkTest;

use PhpRepos\FileManager\Filesystem\Directory;
use PhpRepos\FileManager\Filesystem\Symlink;
use function PhpRepos\FileManager\Resolver\root;
use function PhpRepos\TestRunner\Assertions\Boolean\assert_true;
use function PhpRepos\TestRunner\Runner\test;

test(
    title: 'it should return symlink for the given directory',
    case: function () {
        $directory = Directory::from_string(root() . 'Tests/PlayGround');
        $result = $directory->symlink('symlink');

        assert_true($result instanceof Symlink);
        assert_true(
            Directory::from_string(root() . 'Tests/PlayGround')->append('symlink')->string()
            ===
            $result->path->string()
        );

        return $directory;
    }
);
