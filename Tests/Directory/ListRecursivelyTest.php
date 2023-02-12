<?php

namespace Tests\Directory\ListRecursivelyTest;

use PhpRepos\Datatype\Pair;
use PhpRepos\FileManager\Directory;
use PhpRepos\FileManager\File;
use PhpRepos\FileManager\Path;
use PhpRepos\FileManager\Symlink;
use function PhpRepos\FileManager\Resolver\root;
use function PhpRepos\TestRunner\Assertions\Boolean\assert_true;
use function PhpRepos\TestRunner\Runner\test;

test(
    title: 'it should return a filesystem tree of the directory',
    case: function (Path $playground) {
        $tree = Directory\ls_recursively($playground->append('directory'));

        $directory = Path::from_string($playground->append('directory'));
        $subdirectory = Path::from_string($playground->append('directory/subdirectory'));
        $file1 = Path::from_string($playground->append('directory/file1.txt'));
        $symlink = Path::from_string($playground->append('directory/symlink'));
        $file2 = Path::from_string($playground->append('directory/subdirectory/file2.txt'));
        $file3 = Path::from_string($playground->append('directory/subdirectory/file3.txt'));
        $hidden_directory = Path::from_string($playground->append('directory/subdirectory/.hidden_directory'));
        $hidden_file = Path::from_string($playground->append('directory/subdirectory/.hidden_directory/.hidden_file'));

        assert_true(
            [
                $directory,
                $file1,
                $subdirectory,
                $hidden_directory,
                $hidden_file,
                $file2,
                $file3,
                $symlink,
            ] == $tree->vertices()->items(),
            'filesystem tree vertices not detected correctly'
        );

        assert_true(
            [
                new Pair($directory, $file1),
                new Pair($directory, $subdirectory),
                new Pair($subdirectory, $hidden_directory),
                new Pair($hidden_directory, $hidden_file),
                new Pair($subdirectory, $file2),
                new Pair($subdirectory, $file3),
                new Pair($directory, $symlink),
            ] == $tree->edges()->items(),
            'filesystem tree edges not detected correctly'
        );
    },
    before: function () {
        $playground = Path::from_string(root() . 'Tests/PlayGround');
        Directory\make($playground->append('directory'));
        Directory\make($playground->append('directory/subdirectory'));
        File\create($playground->append('directory/file1.txt'), '');
        Symlink\link($playground->append('directory/file1.txt'), $playground->append('directory/symlink'));
        File\create($playground->append('directory/subdirectory/file2.txt'), '');
        File\create($playground->append('directory/subdirectory/file3.txt'), '');
        Directory\make($playground->append('directory/subdirectory/.hidden_directory'));
        File\create($playground->append('directory/subdirectory/.hidden_directory/.hidden_file'), '');

        return $playground;
    },
    after: function () {
        Directory\delete_recursive(root() . 'Tests/PlayGround/directory');
    }
);
