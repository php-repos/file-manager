<?php

namespace Tests\Symlink\DeleteTest;

use PhpRepos\FileManager\Path;
use PhpRepos\FileManager\File;
use function PhpRepos\FileManager\Resolver\root;
use function PhpRepos\FileManager\Symlink\exists;
use function PhpRepos\FileManager\Symlink\link;
use function PhpRepos\FileManager\Symlink\delete;
use function PhpRepos\TestRunner\Assertions\Boolean\assert_true;
use function PhpRepos\TestRunner\Assertions\Boolean\assert_false;
use function PhpRepos\TestRunner\Runner\test;

test(
    title: 'it should delete the link',
    case: function (Path $file, Path $link) {
        assert_true(delete($link));
        assert_true(File\exists($file));
        assert_false(exists($link));

        return $file;
    },
    before: function () {
        $file = Path::from_string(root() . 'Tests/PlayGround/LinkSource');
        File\create($file, 'file content');
        $link = $file->parent()->append('symlink');
        link($file, $link);

        return [$file, $link];
    },
    after: function (Path $file) {
        File\delete($file);
    }
);
