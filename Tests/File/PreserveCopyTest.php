<?php


use function PhpRepos\FileManager\Paths\append;
use function PhpRepos\FileManager\Paths\root;
use function PhpRepos\FileManager\Directories\delete_recursive;
use function PhpRepos\FileManager\Files\create;
use function PhpRepos\FileManager\Files\permission;
use function PhpRepos\FileManager\Files\preserve_copy;
use function PhpRepos\TestRunner\Assertions\assert_true;
use function PhpRepos\TestRunner\Runner\test;

test(
    title: 'it should preserve copy file',
    case: function (string $first, string $second) {
        $origin = append($first, 'sample.txt');
        $destination = append($second, 'sample.txt');

        assert_true(preserve_copy($origin, $destination));
        assert_true(file_exists($origin), 'origin file does not exist after move!');
        assert_true(file_exists($destination), 'destination file does not exist after move!');
        assert_true(0777 === permission($destination));

        return [$first, $second];
    },
    before: function () {
        $first = append(root(), 'Tests/PlayGround/first');
        $second = append(root(), 'Tests/PlayGround/second');
        mkdir($first);
        mkdir($second);
        $file = append($first, 'sample.txt');
        create($file, 'sample text', 0777);

        return [$first, $second];
    },
    after: function (string $first, string $second) {
        delete_recursive($first);
        delete_recursive($second);
    }
);
