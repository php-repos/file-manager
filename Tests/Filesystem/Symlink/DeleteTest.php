<?php

namespace Tests\Symlink\DeleteTest;

use PhpRepos\FileManager\Filesystem\File;
use PhpRepos\FileManager\Filesystem\Symlink;
use function PhpRepos\FileManager\Resolver\root;
use function PhpRepos\TestRunner\Assertions\Boolean\assert_true;
use function PhpRepos\TestRunner\Assertions\Boolean\assert_false;
use function PhpRepos\TestRunner\Runner\test;

test(
    title: 'it should delete a symlink',
    case: function (File $file, Symlink $symlink) {
        $response = $symlink->delete();
        assert_true($symlink->path->string() === $response->path->string());
        assert_false($symlink->exists());

        return [$file, $symlink];
    },
    before: function () {
        $file = File::from_string(root() . 'Tests/PlayGround/File');
        $file->create('');
        $symlink = Symlink::from_string(root() . 'Tests/PlayGround/Symlink');
        $symlink->link($file);

        return [$file, $symlink];
    }
);
