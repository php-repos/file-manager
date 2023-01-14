<?php

namespace Tests\File\ModifyTest;

use PhpRepos\FileManager\Path;
use function PhpRepos\FileManager\Resolver\root;
use function PhpRepos\FileManager\File\content;
use function PhpRepos\FileManager\File\create;
use function PhpRepos\FileManager\File\modify;
use function PhpRepos\FileManager\File\delete;
use function PhpRepos\FileManager\File\exists;
use function PhpRepos\TestRunner\Assertions\Boolean\assert_true;
use function PhpRepos\TestRunner\Runner\test;

test(
    title: 'it should modify file',
    case: function (Path $file) {
        assert_true(modify($file, 'content in file'));
        assert_true(exists($file));
        assert_true('content in file' === content($file));

        return $file;
    },
    before: function () {
        $file = Path::from_string(root() . 'Tests/PlayGround/sample.txt');
        create($file, 'create content');

        return $file;
    },
    after: function (Path $file) {
        delete($file);
    }
);
