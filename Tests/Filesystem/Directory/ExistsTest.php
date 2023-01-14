<?php

namespace Tests\Filesystem\Directory\ExistsTest;

use PhpRepos\FileManager\Filesystem\Directory;
use function PhpRepos\FileManager\Resolver\root;
use function PhpRepos\TestRunner\Assertions\Boolean\assert_true;
use function PhpRepos\TestRunner\Assertions\Boolean\assert_false;
use function PhpRepos\TestRunner\Runner\test;

test(
    title: 'it should check if directory exists',
    case: function (Directory $directory) {
        assert_false($directory->exists());
        $directory->make();
        assert_true($directory->exists());

        return $directory;
    },
    before: function () {
        return Directory::from_string(root() . 'Tests/PlayGround/DirectoryAddress');
    },
    after: function (Directory $directory) {
        $directory->delete();
    },
);
