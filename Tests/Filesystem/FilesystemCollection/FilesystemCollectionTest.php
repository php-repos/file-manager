<?php

namespace Tests\Filesystem\FilesystemCollection\FilesystemCollectionTest;

use Saeghe\FileManager\Filesystem\Directory;
use Saeghe\FileManager\Filesystem\File;
use Saeghe\FileManager\Filesystem\FilesystemCollection;
use Saeghe\FileManager\Filesystem\Symlink;
use function Saeghe\TestRunner\Assertions\Boolean\assert_true;

test(
    title: 'it should validate key',
    case: function () {
        try {
            new FilesystemCollection(['key' => 'foo']);
            assert_true(false, 'code should not reach to this point');
        } catch (\Exception $exception) {
            assert_true($exception instanceof \InvalidArgumentException);
            assert_true('Invalid key type passed to collection.' === $exception->getMessage());
        }
    }
);

test(
    title: 'it should validate value',
    case: function () {
        try {
            new FilesystemCollection(['foo']);
            assert_true(false, 'code should not reach to this point');
        } catch (\Exception $exception) {
            assert_true($exception instanceof \InvalidArgumentException);
            assert_true('Invalid value type passed to collection.' === $exception->getMessage());
        }
    }
);

test(
    title: 'it should accept Directory, File and Symlink objects',
    case: function () {
        $directory = Directory::from_string('/');
        $file = File::from_string('/file');
        $symlink = Symlink::from_string('/symlink');

        $collection = new FilesystemCollection([$directory, $file, $symlink]);

        assert_true([$directory, $file, $symlink] === $collection->items());
    }
);
