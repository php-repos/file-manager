<?php


use PhpRepos\FileManager\Files;
use function PhpRepos\FileManager\Paths\append;
use function PhpRepos\FileManager\Paths\root;
use function PhpRepos\FileManager\Paths\sibling;
use function PhpRepos\FileManager\Symlinks\exists;
use function PhpRepos\FileManager\Symlinks\link;
use function PhpRepos\FileManager\Symlinks\delete;
use function PhpRepos\TestRunner\Assertions\assert_true;
use function PhpRepos\TestRunner\Assertions\assert_false;
use function PhpRepos\TestRunner\Runner\test;

test(
    title: 'it should delete the link',
    case: function (string $file, string $link) {
        assert_true(delete($link));
        assert_true(Files\exists($file));
        assert_false(exists($link));

        return $file;
    },
    before: function () {
        $file = append(root(), 'Tests/PlayGround/LinkSource');
        Files\create($file, 'file content');
        $link = sibling($file, 'symlink');
        link($file, $link);

        return [$file, $link];
    },
    after: function (string $file) {
        Files\delete($file);
    }
);
