<?php

namespace Tests\Symlink\ExistsTest;

use function PhpRepos\FileManager\Paths\append;
use function PhpRepos\FileManager\Paths\root;
use function PhpRepos\FileManager\Paths\sibling;
use function PhpRepos\FileManager\Symlinks\exists;
use function PhpRepos\FileManager\Symlinks\link;
use function PhpRepos\FileManager\Files\create;
use function PhpRepos\FileManager\Files\delete;
use function PhpRepos\TestRunner\Assertions\assert_true;
use function PhpRepos\TestRunner\Assertions\assert_false;
use function PhpRepos\TestRunner\Runner\test;

test(
    title: 'it should detect when link exists',
    case: function (string $file) {
        $link = sibling($file, 'symlink');
        assert_false(exists($link));

        link($file, $link);
        assert_true(exists($link));

        return [$file, $link];
    },
    before: function () {
        $file = append(root(), 'Tests/PlayGround/LinkSource');
        create($file, 'file content');

        return $file;
    },
    after: function (string $file, string $link) {
        unlink($link);
        delete($file);
    }
);
