<?php


use function PhpRepos\FileManager\Paths\append;
use function PhpRepos\FileManager\Paths\root;
use function PhpRepos\FileManager\Files\content;
use function PhpRepos\FileManager\Files\delete;
use function PhpRepos\TestRunner\Assertions\assert_true;
use function PhpRepos\TestRunner\Runner\test;

test(
    title: 'it should get file content',
    case: function (string $file) {
        assert_true('sample text' === content($file));

        return $file;
    },
    before: function () {
        $file = append(root(), 'Tests/PlayGround/sample.txt');
        file_put_contents($file, 'sample text');

        return $file;
    },
    after: function (string $file) {
        delete($file);
    }
);
