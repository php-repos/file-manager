<?php

namespace Tests\Filesystem\Filename\SymlinkTest;

use PhpRepos\FileManager\Filesystem\Directory;
use PhpRepos\FileManager\Filesystem\Filename;
use PhpRepos\FileManager\Filesystem\Symlink;
use function PhpRepos\TestRunner\Assertions\Boolean\assert_true;
use function PhpRepos\TestRunner\Runner\test;

test(
    title: 'it should return symlink by the filename on the given root',
    case: function () {
        $filename = new Filename('symlink');
        $result = $filename->symlink(Directory::from_string('/home/user'));

        assert_true($result instanceof Symlink);
        assert_true('/home/user/symlink' === $result->path->string());
    }
);
