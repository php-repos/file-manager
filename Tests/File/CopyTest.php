<?php

namespace Tests\File\CopyTest;

use PhpRepos\FileManager\Path;
use function PhpRepos\FileManager\Resolver\root;
use function PhpRepos\FileManager\Directory\delete_recursive;
use function PhpRepos\FileManager\File\copy;
use function PhpRepos\FileManager\File\create;
use function PhpRepos\TestRunner\Assertions\Boolean\assert_true;
use function PhpRepos\TestRunner\Runner\test;

test(
    title: 'it should copy file',
    case: function (Path $first, Path $second) {
        $origin = $first->append('sample.txt');
        $destination = $second->append('sample.txt');

        assert_true(copy($origin, $destination));
        assert_true(file_exists($origin), 'origin file does not exist after move!');
        assert_true(file_exists($destination), 'destination file does not exist after move!');

        return [$first, $second];
    },
    before: function () {
        $first = Path::from_string(root() . 'Tests/PlayGround/first');
        $second = Path::from_string(root() . 'Tests/PlayGround/second');
        mkdir($first);
        mkdir($second);
        $file = $first->append('sample.txt');
        create($file, 'sample text');

        return [$first, $second];
    },
    after: function (Path $first, Path $second) {
        delete_recursive($first);
        delete_recursive($second);
    }
);
