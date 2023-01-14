<?php

namespace Tests\Resolver\RootTest;

use function PhpRepos\FileManager\Resolver\root;
use function PhpRepos\FileManager\Resolver\realpath;
use function PhpRepos\TestRunner\Assertions\Boolean\assert_true;
use function PhpRepos\TestRunner\Runner\test;

test(
    title: 'it should return path to root',
    case: function () {
        assert_true(realpath(__DIR__ . '/../..') . DIRECTORY_SEPARATOR === root());
    }
);
