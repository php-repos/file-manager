<?php

namespace Tests\File\CreateTest;

use PhpRepos\FileManager\Path;
use function PhpRepos\FileManager\Resolver\root;
use function PhpRepos\FileManager\File\content;
use function PhpRepos\FileManager\File\create;
use function PhpRepos\FileManager\File\delete;
use function PhpRepos\FileManager\File\exists;
use function PhpRepos\FileManager\File\permission;
use function PhpRepos\TestRunner\Assertions\Boolean\assert_true;
use function PhpRepos\TestRunner\Runner\test;

test(
    title: 'it should create file',
    case: function () {
        $file = Path::from_string(root() . 'Tests/PlayGround/sample.txt');
        assert_true(create($file, 'content in file'));
        assert_true(exists($file));
        assert_true('content in file' === content($file));
        assert_true(0664 === permission($file));

        return $file;
    },
    after: function (Path $file) {
        delete($file);
    }
);

test(
    title: 'it should create file with given permission',
    case: function () {
        $file = Path::from_string(root() . 'Tests/PlayGround/sample.txt');
        assert_true(create($file, 'content in file', 0765));
        assert_true(exists($file));
        assert_true('content in file' === content($file));
        assert_true(0765 === permission($file));

        return $file;
    },
    after: function (Path $file) {
        delete($file);
    }
);
