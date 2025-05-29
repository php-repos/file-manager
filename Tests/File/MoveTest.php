<?php

namespace Tests\File\MoveTest;

use function PhpRepos\FileManager\Paths\append;
use function PhpRepos\FileManager\Paths\root;
use function PhpRepos\FileManager\Directories\delete_recursive;
use function PhpRepos\FileManager\Files\move;
use function PhpRepos\TestRunner\Assertions\assert_true;
use function PhpRepos\TestRunner\Assertions\assert_false;
use function PhpRepos\TestRunner\Runner\test;

test(
    title: 'it should move file',
    case: function (string $first, string $second) {
        $origin = append($first, 'sample.txt');
        $destination = append($second, 'sample.txt');

        assert_true(move($origin, $destination));

        assert_false(file_exists($origin), 'origin file exists after move!');
        assert_true(file_exists($destination), 'destination file does not exist after move!');

        return [$first, $second];
    },
    before: function () {
        $first = append(root(), 'Tests/PlayGround/first');
        $second = append(root(), 'Tests/PlayGround/second');
        mkdir($first);
        mkdir($second);
        $file = append($first, 'sample.txt');
        file_put_contents($file, 'sample text');

        return [$first, $second];
    },
    after: function (string $first, string $second) {
        delete_recursive($first);
        delete_recursive($second);
    }
);
