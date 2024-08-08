<?php

namespace Tests\File\MoveTest;

use PhpRepos\FileManager\Path;
use function PhpRepos\FileManager\Resolver\root;
use function PhpRepos\FileManager\Directory\delete_recursive;
use function PhpRepos\FileManager\File\move;
use function PhpRepos\TestRunner\Assertions\assert_true;
use function PhpRepos\TestRunner\Assertions\assert_false;
use function PhpRepos\TestRunner\Runner\test;

test(
    title: 'it should move file',
    case: function (Path $first, Path $second) {
        $origin = $first->append('sample.txt');
        $destination = $second->append('sample.txt');

        assert_true(move($origin, $destination));

        assert_false(file_exists($origin), 'origin file exists after move!');
        assert_true(file_exists($destination), 'destination file does not exist after move!');

        return [$first, $second];
    },
    before: function () {
        $first = Path::from_string(root() . 'Tests/PlayGround/first');
        $second = Path::from_string(root() . 'Tests/PlayGround/second');
        mkdir($first);
        mkdir($second);
        $file = $first->append('sample.txt');
        file_put_contents($file, 'sample text');

        return [$first, $second];
    },
    after: function (Path $first, Path $second) {
        delete_recursive($first);
        delete_recursive($second);
    }
);
