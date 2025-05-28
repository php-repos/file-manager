<?php

use function PhpRepos\Datatype\Str\assert_equal;
use function PhpRepos\FileManager\Paths\sibling;
use function PhpRepos\TestRunner\Runner\test;

test(
    title: 'it should return sibling path',
    case: function () {
        assert_equal(sibling('/', 'home'), '/home');
        assert_equal(sibling('/home', 'var'), '/var');
        assert_equal(sibling('/home/user1', 'user2'), '/home/user2');
        assert_equal(sibling('/home/user1/file1.txt', 'file2.txt'), '/home/user1/file2.txt');
        assert_equal(sibling('/home/user1/file1.txt', 'subdirectory/file2.txt'), '/home/user1/subdirectory/file2.txt');
    }
);
