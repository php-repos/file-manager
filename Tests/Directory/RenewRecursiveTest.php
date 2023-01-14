<?php

namespace Tests\Directory\RenewRecursiveTest;

use PhpRepos\FileManager\Path;
use PhpRepos\FileManager\Directory;
use PhpRepos\FileManager\File;
use function PhpRepos\FileManager\Resolver\root;
use function PhpRepos\TestRunner\Assertions\Boolean\assert_true;
use function PhpRepos\TestRunner\Assertions\Boolean\assert_false;
use function PhpRepos\TestRunner\Runner\test;

test(
    title: 'it should clean directory when directory exists',
    case: function (Path $directory) {
        Directory\renew_recursive($directory);
        assert_true(Directory\exists($directory));
        assert_false(File\exists($directory->append('file.txt')));

        return $directory;
    },
    before: function () {
        $directory = Path::from_string(root() . 'Tests/PlayGround/Renew/Recursive');
        Directory\make_recursive($directory);
        file_put_contents($directory->append('file.txt'), 'content');

        return $directory;
    },
    after: function (Path $directory) {
        Directory\delete_recursive($directory->parent());
    }
);

test(
    title: 'it should create the directory recursively when directory not exists',
    case: function () {
        $directory = Path::from_string(root() . 'Tests/PlayGround/Renew/Recursive');

        Directory\renew_recursive($directory);
        assert_true(Directory\exists($directory->parent()));
        assert_true(Directory\exists($directory));

        return $directory;
    },
    after: function (Path $directory) {
        Directory\delete_recursive($directory->parent());
    }
);
