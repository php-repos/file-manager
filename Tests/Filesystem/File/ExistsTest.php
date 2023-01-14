<?php

namespace Tests\Filesystem\File\ExistsTest;

use PhpRepos\FileManager\Filesystem\File;
use function PhpRepos\FileManager\Resolver\root;
use function PhpRepos\TestRunner\Assertions\Boolean\assert_true;
use function PhpRepos\TestRunner\Assertions\Boolean\assert_false;
use function PhpRepos\TestRunner\Runner\test;

test(
    title: 'it should check if symlink exists',
    case: function (File $file) {
        assert_false($file->exists());
        $file->create('');
        assert_true($file->exists());

        return $file;
    },
    before: function () {
        return File::from_string(root() . 'Tests/PlayGround/File');
    },
    after: function (File $file) {
        $file->delete();
    },
);
