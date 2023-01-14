<?php

namespace Tests\Symlink\ExistsTest;

use PhpRepos\FileManager\Filesystem\File;
use PhpRepos\FileManager\Filesystem\Symlink;
use function PhpRepos\FileManager\Resolver\root;
use function PhpRepos\TestRunner\Assertions\Boolean\assert_true;
use function PhpRepos\TestRunner\Assertions\Boolean\assert_false;
use function PhpRepos\TestRunner\Runner\test;

test(
    title: 'it should check if symlink exists',
    case: function (File $file, Symlink $symlink) {
        assert_false($symlink->exists());
        $symlink->link($file);
        assert_true($symlink->exists());

        return [$file, $symlink];
    },
    before: function () {
        $file = File::from_string(root() . 'Tests/PlayGround/File');
        $file->create('');
        $symlink = Symlink::from_string(root() . 'Tests/PlayGround/Symlink');

        return [$file, $symlink];
    },
    after: function (File $file, Symlink $symlink) {
        $symlink->delete();
        $file->delete();
    },
);
