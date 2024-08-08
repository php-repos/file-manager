<?php

namespace Tests\Symlink\LinkTest;

use PhpRepos\FileManager\Path;
use function PhpRepos\FileManager\Resolver\root;
use function PhpRepos\FileManager\Symlink\link;
use function PhpRepos\FileManager\File\create;
use function PhpRepos\FileManager\File\delete;
use function PhpRepos\TestRunner\Assertions\assert_true;
use function PhpRepos\TestRunner\Runner\test;

test(
    title: 'it should create a link to the given source',
    case: function (Path $file) {
        $link = $file->parent()->append('symlink');

        assert_true(link($file, $link));
        assert_true($file->string() === readlink($link));

        return [$file, $link];
    },
    before: function () {
        $file = Path::from_string(root() . 'Tests/PlayGround/LinkSource');
        create($file, 'file content');

        return $file;
    },
    after: function (Path $file, Path $link) {
        unlink($link);
        delete($file);
    }
);
