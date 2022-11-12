<?php

namespace Tests\Filesystem\Filename\FilenameTest;

use Saeghe\FileManager\Filesystem\Filename;
use function Saeghe\TestRunner\Assertions\Boolean\assert_true;

test(
    title: 'filename should be at least one character',
    case: function () {
        try {
            new Filename('');
            assert_true(false, 'code should not reach to this point');
        } catch (\Exception $exception) {
            assert_true('Invalid string passed to text.' === $exception->getMessage());
        }
    }
);

test(
    title: 'filename can be one character',
    case: function () {
        $filename = new Filename('a');
        assert_true('a' === $filename->string());
    }
);

test(
    title: 'filename should be at least two character if start with .',
    case: function () {
        try {
            new Filename('.');
            assert_true(false, 'code should not reach to this point');
        } catch (\Exception $exception) {
            assert_true('Invalid string passed to text.' === $exception->getMessage());
        }
    }
);

test(
    title: 'filename can start with . following by single character',
    case: function () {
        $filename = new Filename('.1');
        assert_true('.1' === $filename->string());
    }
);
