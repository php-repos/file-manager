<?php


use function PhpRepos\FileManager\Directories\clean;
use function PhpRepos\FileManager\JsonFiles\to_array;
use function PhpRepos\FileManager\JsonFiles\write;
use function PhpRepos\FileManager\Paths\append;
use function PhpRepos\FileManager\Paths\parent;
use function PhpRepos\FileManager\Paths\root;
use function PhpRepos\TestRunner\Assertions\assert_true;
use function PhpRepos\TestRunner\Runner\test;

test(
    title: 'it should return associated array from json file',
    case: function (string $file) {
        assert_true(['foo' => 'bar'] === to_array($file));

        return $file;
    },
    before: function () {
        $file = append(root(), 'Tests/PlayGround/File');
        file_put_contents($file, json_encode(['foo' => 'bar']));

        return $file;
    },
    after: function (string $file) {
        clean(parent($file));
    }
);

test(
    title: 'it should write associated array to json file',
    case: function () {
        $file = append(root(), 'Tests/PlayGround/File');
        write($file, ['foo' => 'bar']);
        assert_true(['foo' => 'bar'] === to_array($file));

        return $file;
    },
    after: function (string $file) {
        clean(parent($file));
    }
);
