<?php

use function PhpRepos\Datatype\Str\assert_equal;
use function PhpRepos\FileManager\Paths\append;
use function PhpRepos\TestRunner\Runner\test;

test(
    title: 'it should append base to relative(s)',
    case: function () {
        assert_equal(append('/', 'home'), '/home');
        assert_equal(append('//', 'home/'), '/home');
        assert_equal(append('/', 'home/', '/user'), '/home/user');
        assert_equal(append('/directory1/file1.php', '../directory2/directory3/file2.php'), '/directory1/directory2/directory3/file2.php');
        assert_equal(append('/directory1/file1.php', '..'), '/directory1');
    }
);
