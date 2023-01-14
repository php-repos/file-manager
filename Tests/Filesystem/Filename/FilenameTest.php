<?php

namespace Tests\Filesystem\Filename\FilenameTest;

use PhpRepos\Datatype\Text;
use PhpRepos\FileManager\Filesystem\Filename;
use function PhpRepos\TestRunner\Assertions\Boolean\assert_true;
use function PhpRepos\TestRunner\Runner\test;

test(
    title: 'it implements Text datatype',
    case: function () {
        $filename = new Filename('a');
        assert_true($filename instanceof Text);
        assert_true('a' === $filename->string());
    }
);
