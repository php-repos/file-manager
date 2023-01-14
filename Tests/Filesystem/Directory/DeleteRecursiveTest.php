<?php

namespace Tests\Filesystem\Directory\DeleteRecursiveTest;

use PhpRepos\FileManager\Filesystem\Directory;
use function PhpRepos\FileManager\Resolver\root;
use function PhpRepos\FileManager\Directory\exists;
use function PhpRepos\TestRunner\Assertions\Boolean\assert_true;
use function PhpRepos\TestRunner\Assertions\Boolean\assert_false;
use function PhpRepos\TestRunner\Runner\test;

test(
    title: 'it should delete a directory recursively',
    case: function (Directory $directory, Directory $subdirectory) {
        $response = $directory->delete_recursive();
        assert_true($directory->path->string() === $response->path->string());
        assert_false(exists($directory));
        assert_false(exists($subdirectory));

        return $directory;
    },
    before: function () {
        $directory = Directory::from_string(root() . 'Tests/PlayGround/DirectoryAddress');
        $subdirectory = Directory::from_string(root() . 'Tests/PlayGround/DirectoryAddress/Subdirectory');
        $subdirectory->make_recursive();

        return [$directory, $subdirectory];
    }
);
