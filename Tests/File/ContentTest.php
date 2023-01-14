<?php

namespace Tests\File\ContentTest;

use PhpRepos\FileManager\Path;
use function PhpRepos\FileManager\Resolver\root;
use function PhpRepos\FileManager\File\content;
use function PhpRepos\FileManager\File\delete;
use function PhpRepos\TestRunner\Assertions\Boolean\assert_true;
use function PhpRepos\TestRunner\Runner\test;

test(
    title: 'it should get file content',
    case: function (Path $file) {
        assert_true('sample text' === content($file));

        return $file;
    },
    before: function () {
        $file = Path::from_string(root() . 'Tests/PlayGround/sample.txt');
        file_put_contents($file, 'sample text');

        return $file;
    },
    after: function (Path $file) {
        delete($file);
    }
);
