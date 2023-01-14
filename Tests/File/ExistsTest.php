<?php

namespace Tests\File\ExistsTest;

use PhpRepos\FileManager\Path;
use function PhpRepos\FileManager\Resolver\root;
use function PhpRepos\FileManager\File\exists;
use function PhpRepos\FileManager\Directory\clean;
use function PhpRepos\TestRunner\Assertions\Boolean\assert_true;
use function PhpRepos\TestRunner\Assertions\Boolean\assert_false;
use function PhpRepos\TestRunner\Runner\test;

test(
    title: 'it should return false when file is not exists',
    case: function () {
        $file = Path::from_string(root() . 'Tests/PlayGround/IsExists');
        assert_false(exists($file), 'File/exists is not working!');
    }
);

test(
    title: 'it should return false when given path is a directory',
    case: function (Path $file) {
        assert_false(exists($file), 'File/exists is not working!');

        return $file;
    },
    before: function () {
        $file = Path::from_string(root() . 'Tests/PlayGround/file');

        mkdir($file);

        return $file;
    },
    after: function (Path $file) {
        clean($file->parent());
    }
);

test(
    title: 'it should return true when file is exist and is a file',
    case: function (Path $file) {
        assert_true(exists($file), 'File/exists is not working!');

        return $file;
    },
    before: function () {
        $file = Path::from_string(root() . 'Tests/PlayGround/File');
        file_put_contents($file, 'content');

        return $file;
    },
    after: function (Path $file) {
        clean($file->parent());
    }
);
