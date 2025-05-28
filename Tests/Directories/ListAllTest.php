<?php

namespace Tests\Directories\ListAllTest;

use PhpRepos\FileManager\Directories;
use PhpRepos\FileManager\Files;
use function PhpRepos\Datatype\Arr\assert_equal;
use function PhpRepos\FileManager\Paths\append;
use function PhpRepos\FileManager\Paths\root;
use function PhpRepos\TestRunner\Assertions\assert_true;
use function PhpRepos\TestRunner\Runner\test;

test(
    title: 'it should return list of files and sub directories in the given directory contain hidden files',
    case: function (string $directory) {
        $actual = array_values(iterator_to_array(Directories\ls_all($directory)));
        // Linux and MacOS handle the sorting differently!
        if (stripos(PHP_OS, 'Darwin') !== false) {
            $expected = [
                append($directory, 'sub-directory'),
                append($directory, '.hidden.txt'),
                append($directory, 'sample.txt'),
            ];

        } else {
            $expected = [
                append($directory, 'sample.txt'),
                append($directory, '.hidden.txt'),
                append($directory, 'sub-directory'),
            ];
        }
        assert_equal($actual, $expected);

        return $directory;
    },
    before: function () {
        $directory = append(root(), 'Tests/PlayGround/Directory');
        Directories\make($directory);
        Directories\make(append($directory, 'sub-directory'));
        Files\create(append($directory, 'sample.txt'), '');
        Files\create(append($directory, '.hidden.txt'), '');

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
            [] === iterator_to_array(Directories\ls_all($directory)),
            'Directory list all is not working properly.'
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
