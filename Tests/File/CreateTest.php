<?php


use function PhpRepos\FileManager\Paths\append;
use function PhpRepos\FileManager\Paths\root;
use function PhpRepos\FileManager\Files\content;
use function PhpRepos\FileManager\Files\create;
use function PhpRepos\FileManager\Files\delete;
use function PhpRepos\FileManager\Files\exists;
use function PhpRepos\FileManager\Files\permission;
use function PhpRepos\TestRunner\Assertions\assert_true;
use function PhpRepos\TestRunner\Runner\test;

test(
    title: 'it should create file',
    case: function () {
        $file = append(root(), 'Tests/PlayGround/sample.txt');
        assert_true(create($file, 'content in file'));
        assert_true(exists($file));
        assert_true('content in file' === content($file));
        assert_true(0664 === permission($file));

        return $file;
    },
    after: function (string $file) {
        delete($file);
    }
);

test(
    title: 'it should create file with given permission',
    case: function () {
        $file = append(root(), 'Tests/PlayGround/sample.txt');
        assert_true(create($file, 'content in file', 0765));
        assert_true(exists($file));
        assert_true('content in file' === content($file));
        assert_true(0765 === permission($file));

        return $file;
    },
    after: function (string $file) {
        delete($file);
    }
);
