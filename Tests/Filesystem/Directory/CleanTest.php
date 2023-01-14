<?php

namespace Tests\Directory\CleanTest;

use PhpRepos\FileManager\Filesystem\Directory;
use function PhpRepos\FileManager\Resolver\root;
use function PhpRepos\TestRunner\Assertions\Boolean\assert_true;
use function PhpRepos\TestRunner\Runner\test;

test(
    title: 'it should clean directory',
    case: function (Directory $directory) {
        $directory->clean();

        assert_true($directory->exists());
        assert_true($directory->ls_all()->items() === []);
    },
    before: function () {
        $play_ground = Directory::from_string(root() . 'Tests/PlayGround');
        $play_ground->file('file.txt')->create('test content');
        $play_ground->subdirectory('Subdirectories')->make_recursive();
        $play_ground->subdirectory('Subdirectories')->subdirectory('subdirectory1')->make_recursive();
        $play_ground->subdirectory('Subdirectories')->file('file.txt')->create('test content');

        return $play_ground;
    }
);
