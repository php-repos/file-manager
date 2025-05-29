<?php

use function PhpRepos\Datatype\Str\assert_equal;
use function PhpRepos\FileManager\Paths\extension;
use function PhpRepos\TestRunner\Runner\test;

test(
    title: 'it should return the file extension',
    case: function () {
        assert_equal(extension('/index.php'), 'php');
        assert_equal(extension('/home/file.txt'), 'txt');
        assert_equal(extension('/home/file.phar'), 'phar');
        assert_equal(extension('/home/file'), '');
    }
);
