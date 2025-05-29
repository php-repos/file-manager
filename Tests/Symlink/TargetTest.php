<?php

namespace Tests\Symlink\LinkTest;

use function PhpRepos\FileManager\Paths\append;
use function PhpRepos\FileManager\Paths\root;
use function PhpRepos\FileManager\Paths\sibling;
use function PhpRepos\FileManager\Symlinks\link;
use function PhpRepos\FileManager\Symlinks\target;
use function PhpRepos\FileManager\Files\create;
use function PhpRepos\FileManager\Files\delete;
use function PhpRepos\TestRunner\Assertions\assert_true;
use function PhpRepos\TestRunner\Runner\test;

test(
    title: 'it should return target path to the link',
    case: function (string $file, string $link) {
        assert_true($file === target($link));

        return [$file, $link];
    },
    before: function () {
        $file = append(root(), 'Tests/PlayGround/LinkSource');
        create($file, 'file content');
        $link = sibling($file, 'symlink');
        link($file, $link);

        return [$file, $link];
    },
    after: function (string $file, string $link) {
        unlink($link);
        delete($file);
    }
);
