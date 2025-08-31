<?php


use function PhpRepos\FileManager\Paths\append;
use function PhpRepos\FileManager\Paths\root;
use function PhpRepos\FileManager\Files\delete;
use function PhpRepos\TestRunner\Assertions\assert_true;
use function PhpRepos\TestRunner\Assertions\assert_false;
use function PhpRepos\TestRunner\Runner\test;

test(
    title: 'it should delete file',
    case: function (string $file) {
        assert_true(delete($file));
        assert_false(file_exists($file), 'delete file is not working!');
    },
    before: function () {
        $file = append(root(), 'Tests/PlayGround/sample.txt');
        file_put_contents($file, 'sample text');

        return $file;
    }
);
