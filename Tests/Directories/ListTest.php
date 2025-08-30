<?php

use PhpRepos\FileManager\Directories;
use PhpRepos\FileManager\Files;
use function PhpRepos\Datatype\Arr\assert_equal;
use function PhpRepos\FileManager\Paths\append;
use function PhpRepos\FileManager\Paths\root;
use function PhpRepos\TestRunner\Assertions\assert_true;
use function PhpRepos\TestRunner\Runner\test;

test(
    title: 'it should return list of files and sub directories in the given directory (non-recursive, excluding hidden files)',
    case: function (string $directory) {
        $expected = [
            append($directory, 'sub-directory'),
            append($directory, 'sample.txt'),
        ];
        assert_equal(Directories\ls($directory), $expected);

        return $directory;
    },
    before: function () {
        $directory = append(root(), 'Tests/PlayGround/Directory');
        Directories\make($directory);
        Directories\make(append($directory, 'sub-directory'));
        Files\create(append($directory, 'sample.txt'), '');
        Files\create(append($directory, '.hidden.txt'), '');
        // Create a nested file to ensure non-recursive behavior
        Files\create(append($directory, 'sub-directory/nested.txt'), '');

        return $directory;
    },
    after: function (string $directory) {
        Directories\delete_recursive($directory);
    }
);

test(
    title: 'it should return empty array when directory is empty',
    case: function (string $directory) {
        assert_true(
            [] === Directories\ls($directory),
            'Directory list is not working properly.'
        );

        return $directory;
    },
    before: function () {
        $directory = append(root(), 'Tests/PlayGround/Directory');
        Directories\make($directory);

        return $directory;
    },
    after: function (string $directory) {
        Directories\delete_recursive($directory);
    }
);
