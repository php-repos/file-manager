<?php

namespace Tests\Symlink\LinkTest;

use PhpRepos\FileManager\Path;
use function PhpRepos\FileManager\Resolver\root;
use function PhpRepos\FileManager\Symlink\link;
use function PhpRepos\FileManager\Symlink\target;
use function PhpRepos\FileManager\File\create;
use function PhpRepos\FileManager\File\delete;
use function PhpRepos\TestRunner\Assertions\assert_true;
use function PhpRepos\TestRunner\Runner\test;

test(
    title: 'it should return target path to the link',
    case: function (Path $file, Path $link) {
        assert_true($file->string() === target($link));

        return [$file, $link];
    },
    before: function () {
        $file = Path::from_string(root() . 'Tests/PlayGround/LinkSource');
        create($file, 'file content');
        $link = $file->parent()->append('symlink');
        link($file, $link);

        return [$file, $link];
    },
    after: function (Path $file, Path $link) {
        unlink($link);
        delete($file);
    }
);
