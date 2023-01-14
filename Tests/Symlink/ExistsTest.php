<?php

namespace Tests\Symlink\ExistsTest;

use PhpRepos\FileManager\Path;
use function PhpRepos\FileManager\Resolver\root;
use function PhpRepos\FileManager\Symlink\exists;
use function PhpRepos\FileManager\Symlink\link;
use function PhpRepos\FileManager\File\create;
use function PhpRepos\FileManager\File\delete;
use function PhpRepos\TestRunner\Assertions\Boolean\assert_true;
use function PhpRepos\TestRunner\Assertions\Boolean\assert_false;
use function PhpRepos\TestRunner\Runner\test;

test(
    title: 'it should detect when link exists',
    case: function (Path $file) {
        $link = $file->parent()->append('symlink');
        assert_false(exists($link));

        link($file, $link);
        assert_true(exists($link));

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
