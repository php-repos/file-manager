<?php

namespace Tests\Directories\IsEmptyTest;

use function PhpRepos\FileManager\Paths\append;
use function PhpRepos\FileManager\Paths\root;
use function PhpRepos\FileManager\Directories\delete_recursive;
use function PhpRepos\FileManager\Directories\is_empty;
use function PhpRepos\TestRunner\Assertions\assert_true;
use function PhpRepos\TestRunner\Assertions\assert_false;
use function PhpRepos\TestRunner\Runner\test;

test(
    title: 'it should return true when directory is empty',
    case: function (string $directory) {
        assert_true(is_empty($directory));

        return $directory;
    },
    before: function () {
        $directory = append(root(), 'Tests/PlayGround/Temp');
        mkdir($directory);
        return $directory;
    },
    after: function (string $directory) {
        delete_recursive($directory);
    }
);

test(
    title: 'it should return false when directory has file empty',
    case: function (string $directory) {
        assert_false(is_empty($directory));

        return $directory;
    },
    before: function () {
        $directory = append(root(), 'Tests/PlayGround/IsEmpty');
        mkdir($directory);
        file_put_contents(append($directory, 'file.txt'),'content');

        return $directory;
    },
    after: function (string $directory) {
        delete_recursive($directory);
    }
);

test(
    title: 'it should return false when directory has sub directory empty',
    case: function (string $directory) {
        assert_false(is_empty($directory));

        return $directory;
    },
    before: function () {
        $directory = append(root(), 'Tests/PlayGround/IsEmpty');
        mkdir($directory);
        mkdir(append($directory, 'sub_directory'));

        return $directory;
    },
    after: function (string $directory) {
        delete_recursive($directory);
    }
);
