<?php

namespace Tests\Directory\ListAllTest;

use PhpRepos\FileManager\Path;
use PhpRepos\FileManager\Directory;
use PhpRepos\FileManager\File;
use function PhpRepos\FileManager\Resolver\root;
use function PhpRepos\TestRunner\Assertions\assert_true;
use function PhpRepos\TestRunner\Runner\test;

test(
    title: 'it should return list of files and sub directories in the given directory contain hidden files',
    case: function (Path $directory) {
        assert_true(
            [
                $directory->append('.hidden.txt'),
                $directory->append('sample.txt'),
                $directory->append('sub-directory'),
            ] == Directory\ls_all($directory)->items(),
            'Directory list all is not working properly.'
        );

        return $directory;
    },
    before: function () {
        $directory = Path::from_string(root() . 'Tests/PlayGround/Directory');
        Directory\make($directory);
        Directory\make($directory->append('sub-directory'));
        File\create($directory->append('sample.txt'), '');
        File\create($directory->append('.hidden.txt'), '');

        return $directory;
    },
    after: function (Path $directory) {
        Directory\delete_recursive($directory);
    }
);

test(
    title: 'it should return empty array when directory is empty',
    case: function (Path $directory) {
        assert_true(
            [] === Directory\ls_all($directory)->items(),
            'Directory list all is not working properly.'
        );

        return $directory;
    },
    before: function () {
        $directory = Path::from_string(root() . 'Tests/PlayGround/Directory');
        Directory\make($directory);

        return $directory;
    },
    after: function (Path $directory) {
        Directory\delete_recursive($directory);
    }
);
