<?php

namespace Tests\Directories\MakeRecursiveTest;

use PhpRepos\FileManager\Directories;
use function PhpRepos\FileManager\Paths\append;
use function PhpRepos\FileManager\Paths\parent;
use function PhpRepos\FileManager\Paths\root;
use function PhpRepos\TestRunner\Assertions\assert_true;
use function PhpRepos\TestRunner\Runner\test;

test(
    title: 'it should create directory recursively with function',
    case: function () {
        $directory = append(root(), 'Tests/PlayGround/Origin/MakeRecursive');

        assert_true(Directories\make_recursive($directory));
        assert_true(Directories\exists(parent($directory)), '2');
        assert_true(Directories\exists($directory), '3');

        return $directory;
    },
    after: function (string $directory) {
        Directories\delete_recursive(parent($directory));
    }
);

test(
    title: 'it should create directory recursively with given permission',
    case: function () {
        $directory = append(root(), 'Tests/PlayGround/Origin/MakeRecursive');

        assert_true(Directories\make_recursive($directory, 0777));
        assert_true(Directories\exists(parent($directory)));
        assert_true(0777 === Directories\permission(parent($directory)));
        assert_true(Directories\exists($directory));
        assert_true(0777 === Directories\permission($directory));

        return $directory;
    },
    after: function (string $directory) {
        Directories\delete_recursive(parent($directory));
    }
);
