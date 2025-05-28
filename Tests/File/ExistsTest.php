<?php

namespace Tests\File\ExistsTest;

use function PhpRepos\FileManager\Paths\append;
use function PhpRepos\FileManager\Paths\parent;
use function PhpRepos\FileManager\Paths\root;
use function PhpRepos\FileManager\Files\exists;
use function PhpRepos\FileManager\Directories\clean;
use function PhpRepos\TestRunner\Assertions\assert_true;
use function PhpRepos\TestRunner\Assertions\assert_false;
use function PhpRepos\TestRunner\Runner\test;

test(
    title: 'it should return false when file is not exists',
    case: function () {
        $file = append(root(), 'Tests/PlayGround/IsExists');
        assert_false(exists($file), 'File/exists is not working!');
    }
);

test(
    title: 'it should return false when given path is a directory',
    case: function (string $file) {
        assert_false(exists($file), 'File/exists is not working!');

        return $file;
    },
    before: function () {
        $file = append(root(), 'Tests/PlayGround/file');

        mkdir($file);

        return $file;
    },
    after: function (string $file) {
        clean(parent($file));
    }
);

test(
    title: 'it should return true when file is exist and is a file',
    case: function (string $file) {
        assert_true(exists($file), 'File/exists is not working!');

        return $file;
    },
    before: function () {
        $file = append(root(), 'Tests/PlayGround/File');
        file_put_contents($file, 'content');

        return $file;
    },
    after: function (string $file) {
        clean(parent($file));
    }
);
