<?php

namespace Tests\JsonFileTest;

use PhpRepos\FileManager\Path;
use function PhpRepos\FileManager\Directory\clean;
use function PhpRepos\FileManager\JsonFile\to_array;
use function PhpRepos\FileManager\JsonFile\write;
use function PhpRepos\FileManager\Resolver\root;
use function PhpRepos\TestRunner\Assertions\assert_true;
use function PhpRepos\TestRunner\Runner\test;

test(
    title: 'it should return associated array from json file',
    case: function (Path $file) {
        assert_true(['foo' => 'bar'] === to_array($file));

        return $file;
    },
    before: function () {
        $file = Path::from_string(root() . 'Tests/PlayGround/File');
        file_put_contents($file, json_encode(['foo' => 'bar']));

        return $file;
    },
    after: function (Path $file) {
        clean($file->parent());
    }
);

test(
    title: 'it should write associated array to json file',
    case: function () {
        $file = Path::from_string(root() . 'Tests/PlayGround/File');
        write($file, ['foo' => 'bar']);
        assert_true(['foo' => 'bar'] === to_array($file));

        return $file;
    },
    after: function (Path $file) {
        clean($file->parent());
    }
);
