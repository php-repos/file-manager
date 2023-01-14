<?php

namespace Tests\Filesystem\Directory\DeleteTest;

use PhpRepos\FileManager\Filesystem\Directory;
use function PhpRepos\FileManager\Resolver\root;
use function PhpRepos\FileManager\Directory\exists;
use function PhpRepos\TestRunner\Assertions\Boolean\assert_true;
use function PhpRepos\TestRunner\Assertions\Boolean\assert_false;
use function PhpRepos\TestRunner\Runner\test;

test(
    title: 'it should delete a directory',
    case: function (Directory $directory) {
        $response = $directory->delete();
        assert_true($directory->path->string() === $response->path->string());
        assert_false(exists($directory));
    },
    before: function () {
        $directory = Directory::from_string(root() . 'Tests/PlayGround/DirectoryAddress');
        $directory->make();

        return $directory;
    }
);
