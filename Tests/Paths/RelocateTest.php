<?php

use function PhpRepos\Datatype\Str\assert_equal;
use function PhpRepos\FileManager\Paths\relocate;
use function PhpRepos\TestRunner\Runner\test;

test(
    title: 'it should return sibling path',
    case: function () {
        assert_equal(relocate('/home/file1', '/home', '/var'), '/var/file1');
        assert_equal(relocate('/home/directory1/file1', '/home/directory1', '/home/directory2'), '/home/directory2/file1');
        assert_equal(relocate('/home/directory1/file1', '/home/directory1/file1', '/home/directory2/file2'), '/home/directory2/file2');
        assert_equal(relocate('/home/directory1/file1.php', 'file1.php', 'file2.php'), '/home/directory1/file2.php');
        assert_equal(relocate('/home/directory1/file1.php', 'file1.php', 'file1.phar'), '/home/directory1/file1.phar');
        assert_equal(relocate('/home/user/docs/file.txt', 'docs', 'images'), '/home/user/images/file.txt');
    }
);
