<?php

namespace Tests\Filesystem\File\ContentTest;

use PhpRepos\FileManager\Filesystem\File;
use function PhpRepos\FileManager\Resolver\root;
use function PhpRepos\TestRunner\Assertions\Boolean\assert_true;
use function PhpRepos\TestRunner\Runner\test;

test(
    title: 'it should get file content',
    case: function (File $file) {
        assert_true('sample text' === $file->content());

        return $file;
    },
    before: function () {
        $file = File::from_string(root() . 'Tests/PlayGround/sample.txt');
        $file->create('sample text');

        return $file;
    },
    after: function (File $file) {
        $file->delete();
    }
);
