<?php

namespace Tests\Directories\RenewTest;

use PhpRepos\FileManager\Directories;
use PhpRepos\FileManager\Files;
use function PhpRepos\FileManager\Paths\append;
use function PhpRepos\FileManager\Paths\root;
use function PhpRepos\TestRunner\Assertions\assert_true;
use function PhpRepos\TestRunner\Assertions\assert_false;
use function PhpRepos\TestRunner\Runner\test;

test(
    title: 'it should clean directory when directory exists',
    case: function (string $directory) {
        Directories\renew($directory);
        assert_true(Directories\exists($directory));
        assert_false(Files\exists(append($directory, 'file.txt')));

        return $directory;
    },
    before: function () {
        $directory = append(root(), 'Tests/PlayGround/Renew');
        Directories\make($directory);
        file_put_contents(append($directory, 'file.txt'), 'content');

        return $directory;
    },
    after: function (string $directory) {
        Directories\delete_recursive($directory);
    }
);

test(
    title: 'it should create the directory when directory not exists',
    case: function () {
        $directory = append(root(), 'Tests/PlayGround/Renew');

        Directories\renew($directory);
        assert_true(Directories\exists($directory));

        return $directory;
    },
    after: function (string $directory) {
        Directories\delete_recursive($directory);
    }
);
