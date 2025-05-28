<?php

namespace Tests\Resolver\RootTest;

use function PhpRepos\FileManager\Paths\root;
use function PhpRepos\FileManager\Paths\realpath;
use function PhpRepos\TestRunner\Assertions\assert_true;
use function PhpRepos\TestRunner\Runner\test;

test(
    title: 'it should return path to root',
    case: function () {
        assert_true(realpath(__DIR__ . '/../..') . DIRECTORY_SEPARATOR === root());
    }
);
