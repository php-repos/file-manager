<?php


use PhpRepos\FileManager\Directories;
use function PhpRepos\FileManager\Paths\append;
use function PhpRepos\FileManager\Paths\root;
use function PhpRepos\TestRunner\Assertions\assert_true;
use function PhpRepos\TestRunner\Runner\test;

test(
    title: 'it should return true when directory exists',
    case: function (string $directory) {
        assert_true(Directories\exists_or_create($directory));

        return $directory;
    },
    before: function () {
        $directory = append(root(), 'Tests/PlayGround/ExistsOrCreate');
        Directories\make($directory);

        return $directory;
    },
    after: function (string $directory) {
        Directories\delete($directory);
    }
);

test(
    title: 'it should create and return true when directory not exists',
    case: function () {
        $directory = append(root(), 'Tests/PlayGround/ExistsOrCreate');

        assert_true(Directories\exists_or_create($directory));
        assert_true(Directories\exists($directory));

        return $directory;
    },
    after: function (string $directory) {
        Directories\delete($directory);
    }
);
