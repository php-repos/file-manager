<?php

namespace Tests\FilenameTest;

use PhpRepos\FileManager\Filename;
use function PhpRepos\TestRunner\Assertions\assert_true;
use function PhpRepos\TestRunner\Runner\test;

test(
    title: 'it should construct a filename',
    case: function () {
        $filename = new Filename('file.txt');

        assert_true((string) $filename === 'file.txt');
    }
);
