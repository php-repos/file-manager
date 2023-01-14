<?php

namespace Tests\Filesystem\Filename\DirectoryTest;

use PhpRepos\FileManager\Filesystem\Directory;
use PhpRepos\FileManager\Filesystem\Filename;
use function PhpRepos\TestRunner\Assertions\Boolean\assert_true;
use function PhpRepos\TestRunner\Runner\test;

test(
    title: 'it should return subdirectory by the filename on the given root',
    case: function () {
        $filename = new Filename('subdirectory');
        $result = $filename->directory(Directory::from_string('/home/user'));

        assert_true($result instanceof Directory);
        assert_true('/home/user/subdirectory' === $result->path->string());
    }
);
