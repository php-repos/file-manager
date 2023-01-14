<?php

namespace Tests\Filesystem\Directory\RecursivelyTest;

use PhpRepos\Datatype\Pair;
use PhpRepos\FileManager\Filesystem\Directory;
use function PhpRepos\FileManager\Resolver\root;
use function PhpRepos\TestRunner\Assertions\Boolean\assert_true;
use function PhpRepos\TestRunner\Runner\test;

test(
    title: 'it should return subdirectories recursively',
    case: function (Directory $directory) {
        $results = $directory->recursively();

        assert_true([
            $directory,
            $directory->file('.hidden'),
            $directory->subdirectory('Subdirectories'),
            $directory->subdirectory('Subdirectories')->file('file1.txt'),
            $directory->subdirectory('Subdirectories')->subdirectory('subdirectory1'),
            $directory->subdirectory('Subdirectories')->subdirectory('subdirectory1')->subdirectory('subdirectory3'),
            $directory->subdirectory('Subdirectories')->subdirectory('subdirectory1')->subdirectory('subdirectory3')->file('file2.txt'),
            $directory->subdirectory('Subdirectories')->subdirectory('subdirectory1')->subdirectory('subdirectory3')->symlink('symlink2'),
            $directory->subdirectory('Subdirectories')->subdirectory('subdirectory1')->symlink('symlink1'),
            $directory->subdirectory('Subdirectories')->subdirectory('subdirectory2'),
        ] == $results->vertices()->items(), 'Vertices do not match');

        assert_true([
            new Pair($directory, $directory->file('.hidden')),
            new Pair($directory, $directory->subdirectory('Subdirectories')),
            new Pair($directory->subdirectory('Subdirectories'), $directory->subdirectory('Subdirectories')->file('file1.txt')),
            new Pair($directory->subdirectory('Subdirectories'), $directory->subdirectory('Subdirectories')->subdirectory('subdirectory1')),
            new Pair(
                $directory->subdirectory('Subdirectories')->subdirectory('subdirectory1'),
                $directory->subdirectory('Subdirectories')->subdirectory('subdirectory1')->subdirectory('subdirectory3')
            ),
            new Pair(
                $directory->subdirectory('Subdirectories')->subdirectory('subdirectory1')->subdirectory('subdirectory3'),
                $directory->subdirectory('Subdirectories')->subdirectory('subdirectory1')->subdirectory('subdirectory3')->file('file2.txt')
            ),
            new Pair(
                $directory->subdirectory('Subdirectories')->subdirectory('subdirectory1')->subdirectory('subdirectory3'),
                $directory->subdirectory('Subdirectories')->subdirectory('subdirectory1')->subdirectory('subdirectory3')->symlink('symlink2')
            ),
            new Pair(
                $directory->subdirectory('Subdirectories')->subdirectory('subdirectory1'),
                $directory->subdirectory('Subdirectories')->subdirectory('subdirectory1')->symlink('symlink1')
            ),
            new Pair($directory->subdirectory('Subdirectories'), $directory->subdirectory('Subdirectories')->subdirectory('subdirectory2')),
        ] == $results->edges()->items(), 'Edges do not match');

        return $directory;
    },
    before: function () {
        $play_ground = Directory::from_string(root() . 'Tests/PlayGround');
        $play_ground->file('.hidden')->create('');
        $play_ground->subdirectory('Subdirectories')->make_recursive();
        $play_ground->subdirectory('Subdirectories')->file('file1.txt')->create('');
        $play_ground->subdirectory('Subdirectories')->subdirectory('subdirectory1')->make_recursive();
        $play_ground->subdirectory('Subdirectories')->subdirectory('subdirectory1')->symlink('symlink1')
            ->link($play_ground->subdirectory('Subdirectories')->file('file1.txt'));
        $play_ground->subdirectory('Subdirectories')->subdirectory('subdirectory2')->make_recursive();
        $play_ground->subdirectory('Subdirectories')->subdirectory('subdirectory1')->subdirectory('subdirectory3')->make_recursive();
        $play_ground->subdirectory('Subdirectories')->subdirectory('subdirectory1')->subdirectory('subdirectory3')->file('file2.txt')->create('');
        $play_ground->subdirectory('Subdirectories')->subdirectory('subdirectory1')->subdirectory('subdirectory3')->symlink('symlink2')
            ->link($play_ground->subdirectory('Subdirectories')->subdirectory('subdirectory1')->subdirectory('subdirectory3')->file('file2.txt'));
        return $play_ground;
    },
    after: function (Directory $directory) {
        $directory->clean();
    }
);
