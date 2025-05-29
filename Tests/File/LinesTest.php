<?php

namespace Tests\File\LinesTest;

use PhpRepos\FileManager\Files;
use function PhpRepos\FileManager\Paths\append;
use function PhpRepos\FileManager\Paths\root;
use function PhpRepos\TestRunner\Assertions\assert_true;
use function PhpRepos\TestRunner\Runner\test;

test(
    title: 'it should read file\'s lines',
    case: function (string $file) {
        $results = [];

        foreach (Files\lines($file) as $n => $line) {
            $results[$n] = $line;
        }

        assert_true([0 => 'First line.' . PHP_EOL, 1 => 'Second line.'] === $results);

        return $file;
    },
    before: function () {
        $file = append(root(), 'Tests/PlayGround/NewFile.txt');
        Files\create($file, 'First line.' . PHP_EOL . 'Second line.');

        return $file;
    },
    after: function (string $file) {
        Files\delete($file);
    }
);
