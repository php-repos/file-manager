<?php

use function PhpRepos\Datatype\Str\assert_equal;
use function PhpRepos\FileManager\Paths\parent;
use function PhpRepos\TestRunner\Runner\test;

test(
    title: 'it should return the parent',
    case: function () {
        assert_equal(parent('/'), '/');
        assert_equal(parent('/home'), '/');
        assert_equal(parent('/home/file.php'), '/home');
        assert_equal(parent('/home/subdirectory/file.php'), '/home/subdirectory');
    }
);
