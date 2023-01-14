<?php

namespace Tests\Filesystem\File\DeleteTest;

use PhpRepos\FileManager\Filesystem\File;
use function PhpRepos\FileManager\Resolver\root;
use function PhpRepos\FileManager\File\exists;
use function PhpRepos\TestRunner\Assertions\Boolean\assert_true;
use function PhpRepos\TestRunner\Assertions\Boolean\assert_false;
use function PhpRepos\TestRunner\Runner\test;

test(
    title: 'it should delete a file',
    case: function (File $file) {
        $response = $file->delete();
        assert_true($file->path->string() === $response->path->string());
        assert_false(exists($file));

        return $file;
    },
    before: function () {
        $file = File::from_string(root() . 'Tests/PlayGround/File');
        $file->create('');

        return $file;
    }
);
