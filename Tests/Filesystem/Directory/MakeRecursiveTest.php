<?php

namespace Tests\Filesystem\Directory\MakeRecursiveTest;

use PhpRepos\FileManager\Filesystem\Directory;
use function PhpRepos\FileManager\Resolver\root;
use function PhpRepos\TestRunner\Assertions\Boolean\assert_true;
use function PhpRepos\TestRunner\Runner\test;

test(
    title: 'it should create directory recursively',
    case: function () {
        $directory = Directory::from_string(root() . 'Tests/PlayGround/Origin/MakeRecursive');

        $result = $directory->make_recursive();
        assert_true($result->path->string() === $directory->path->string());
        assert_true($directory->parent()->exists());
        assert_true($directory->exists());

        return $directory;
    },
    after: function (Directory $directory) {
        $directory->parent()->delete_recursive();
    }
);

test(
    title: 'it should create directory recursively with given permission',
    case: function () {
        $directory = Directory::from_string(root() . 'Tests/PlayGround/Origin/MakeRecursive');

        $directory->make_recursive(0777);

        assert_true($directory->parent()->exists());
        assert_true(0777 === $directory->parent()->permission());
        assert_true($directory->exists());
        assert_true(0777 === $directory->permission());

        return $directory;
    },
    after: function (Directory $directory) {
        $directory->parent()->delete_recursive();
    }
);
