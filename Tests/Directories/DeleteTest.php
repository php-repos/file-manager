<?php


use PhpRepos\FileManager\Directories;
use function PhpRepos\FileManager\Paths\append;
use function PhpRepos\FileManager\Paths\root;
use function PhpRepos\TestRunner\Assertions\assert_false;
use function PhpRepos\TestRunner\Runner\test;

test(
    title: 'it should delete the given directory',
    case: function (string $directory) {
        Directories\delete($directory);

        assert_false(Directories\exists($directory));
    },
    before: function () {
        $directory = append(root(), 'Tests/PlayGround/DeleteDirectory');
        mkdir($directory);

        return $directory;
    }
);
