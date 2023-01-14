<?php

namespace Tests\Filesystem\File\ChmodTest;

use PhpRepos\FileManager\Filesystem\Directory;
use PhpRepos\FileManager\Filesystem\File;
use function PhpRepos\FileManager\Resolver\root;
use function PhpRepos\TestRunner\Assertions\Boolean\assert_true;
use function PhpRepos\TestRunner\Runner\test;

test(
    title: 'it should change file\'s permission',
    case: function () {
        $playGround = Directory::from_string(root() . 'Tests/PlayGround');
        $regular = $playGround->file('regular');
        $regular->create('content');
        $result = $regular->chmod(0664);
        assert_true($result instanceof File);
        assert_true($result->path->string() === $regular->path->string());
        assert_true(0664 === $regular->permission());

        $full = $playGround->file('full');
        $full->create('full');
        $full->chmod(0777);

        assert_true(0777 === $full->permission());

        return [$regular, $full];
    },
    after: function (File $regular, File $full) {
        $regular->delete();
        $full->delete();
    }
);
