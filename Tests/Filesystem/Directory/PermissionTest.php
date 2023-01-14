<?php

namespace Tests\Filesystem\Directory\PermissionTest;

use PhpRepos\FileManager\Filesystem\Directory;
use function PhpRepos\FileManager\Resolver\root;
use function PhpRepos\TestRunner\Assertions\Boolean\assert_true;
use function PhpRepos\TestRunner\Runner\test;

test(
    title: 'it should return directory\'s permission',
    case: function () {
        $playGround = Directory::from_string(root() . 'Tests/PlayGround');
        $regular = $playGround->subdirectory('regular');
        $regular->make(0774);
        assert_true(0774 === $regular->permission());

        $full = $playGround->subdirectory('full');
        $full->make(0777);
        assert_true(0777 === $full->permission());

        return [$regular, $full];
    },
    after: function (Directory $regular, Directory $full) {
        $regular->delete();
        $full->delete();
    }
);

test(
    title: 'it should not return cached permission',
    case: function () {
        $playGround = Directory::from_string(root() . 'Tests/PlayGround');
        $directory = $playGround->subdirectory('regular');
        $directory->make();
        assert_true(0775 === $directory->permission());
        chmod($directory, 0774);
        assert_true(0774 === $directory->permission());

        return $directory;
    },
    after: function (Directory $directory) {
        $directory->delete();
    }
);
