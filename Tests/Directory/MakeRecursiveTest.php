<?php

namespace Tests\Directory\MakeRecursiveTest;

use PhpRepos\FileManager\Path;
use PhpRepos\FileManager\Directory;
use function PhpRepos\FileManager\Resolver\root;
use function PhpRepos\TestRunner\Assertions\assert_true;
use function PhpRepos\TestRunner\Runner\test;

test(
    title: 'it should create directory recursively with function',
    case: function () {
        $directory = Path::from_string(root() . 'Tests/PlayGround/Origin/MakeRecursive');

        assert_true(Directory\make_recursive($directory));
        assert_true(Directory\exists($directory->parent()), '2');
        assert_true(Directory\exists($directory), '3');

        return $directory;
    },
    after: function (Path $directory) {
        Directory\delete_recursive($directory->parent());
    }
);

test(
    title: 'it should create directory recursively with given permission',
    case: function () {
        $directory = Path::from_string(root() . 'Tests/PlayGround/Origin/MakeRecursive');

        assert_true(Directory\make_recursive($directory, 0777));
        assert_true(Directory\exists($directory->parent()));
        assert_true(0777 === Directory\permission($directory->parent()));
        assert_true(Directory\exists($directory));
        assert_true(0777 === Directory\permission($directory));

        return $directory;
    },
    after: function (Path $directory) {
        Directory\delete_recursive($directory->parent());
    }
);
