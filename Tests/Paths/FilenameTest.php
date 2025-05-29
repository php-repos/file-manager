<?php

use function PhpRepos\Datatype\Str\assert_equal;
use function PhpRepos\FileManager\Paths\filename;
use function PhpRepos\TestRunner\Runner\test;

test(
    title: 'it should return the filename',
    case: function () {
        assert_equal(filename('/'), '');
        assert_equal(filename('/home'), 'home');
        assert_equal(filename('/home/file.php'), 'file.php');
        assert_equal(filename('/home/subdirectory/file.php'), 'file.php');
    }
);
