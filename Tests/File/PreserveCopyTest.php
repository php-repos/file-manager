<?php

namespace Tests\File\PreserveCopyTest;

use PhpRepos\FileManager\Path;
use function PhpRepos\FileManager\Resolver\root;
use function PhpRepos\FileManager\Directory\delete_recursive;
use function PhpRepos\FileManager\File\create;
use function PhpRepos\FileManager\File\permission;
use function PhpRepos\FileManager\File\preserve_copy;
use function PhpRepos\TestRunner\Assertions\assert_true;
use function PhpRepos\TestRunner\Runner\test;

test(
    title: 'it should preserve copy file',
    case: function (Path $first, Path $second) {
        $origin = $first->append('sample.txt');
        $destination = $second->append('sample.txt');

        assert_true(preserve_copy($origin, $destination));
        assert_true(file_exists($origin), 'origin file does not exist after move!');
        assert_true(file_exists($destination), 'destination file does not exist after move!');
        assert_true(0777 === permission($destination));

        return [$first, $second];
    },
    before: function () {
        $first = Path::from_string(root() . 'Tests/PlayGround/first');
        $second = Path::from_string(root() . 'Tests/PlayGround/second');
        mkdir($first);
        mkdir($second);
        $file = $first->append('sample.txt');
        create($file, 'sample text', 0777);

        return [$first, $second];
    },
    after: function (Path $first, Path $second) {
        delete_recursive($first);
        delete_recursive($second);
    }
);
