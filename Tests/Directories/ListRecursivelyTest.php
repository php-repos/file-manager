<?php

use PhpRepos\FileManager\Directories;
use PhpRepos\FileManager\Files;
use function PhpRepos\Datatype\Arr\assert_equal;
use function PhpRepos\FileManager\Paths\append;
use function PhpRepos\FileManager\Paths\root;
use function PhpRepos\TestRunner\Assertions\assert_true;
use function PhpRepos\TestRunner\Runner\test;

test(
    title: 'it should return list of files and sub directories recursively in the given directory (excluding hidden files)',
    case: function (string $directory) {
        $actual = array_values(iterator_to_array(Directories\ls_recursively($directory)));
        sort($actual);
        
        $expected = [
            append($directory, 'sample.txt'),
            append($directory, 'sub-directory'),
            append($directory, 'sub-directory/nested.txt'),
        ];
        sort($expected);
        
        assert_equal($actual, $expected);

        return $directory;
    },
    before: function () {
        $directory = append(root(), 'Tests/PlayGround/Directory');
        Directories\make($directory);
        Directories\make(append($directory, 'sub-directory'));
        Files\create(append($directory, 'sample.txt'), '');
        Files\create(append($directory, '.hidden.txt'), '');
        Files\create(append($directory, 'sub-directory/nested.txt'), '');
        Files\create(append($directory, 'sub-directory/.hidden-nested.txt'), '');

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
            [] === iterator_to_array(Directories\ls_recursively($directory)),
            'Directory list recursively is not working properly.'
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
