<?php

namespace Tests\Filesystem\Filename\FileTest;

use PhpRepos\FileManager\Filesystem\Directory;
use PhpRepos\FileManager\Filesystem\File;
use PhpRepos\FileManager\Filesystem\Filename;
use function PhpRepos\TestRunner\Assertions\Boolean\assert_true;
use function PhpRepos\TestRunner\Runner\test;

test(
    title: 'it should return file by the filename on the given root',
    case: function () {
        $filename = new Filename('filename');
        $result = $filename->file(Directory::from_string('/home/user'));

        assert_true($result instanceof File);
        assert_true('/home/user/filename' === $result->path->string());
    }
);
