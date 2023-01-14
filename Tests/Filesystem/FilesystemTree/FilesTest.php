<?php

namespace Tests\Filesystem\FilesystemTree;

use PhpRepos\FileManager\Filesystem\Directory;
use PhpRepos\FileManager\Filesystem\FilesystemTree;
use function PhpRepos\TestRunner\Assertions\Boolean\assert_true;
use function PhpRepos\TestRunner\Runner\test;

test(
    title: 'it should return files from the tree',
    case: function () {
        $root = Directory::from_string('/');
        $root_file = $root->file('file');
        $home = $root->subdirectory('home');
        $file1 = $home->file('file1');
        $symlink = $home->symlink('symlink');
        $documents = $home->subdirectory('documents');
        $document_file = $documents->file('file');

        $tree = new FilesystemTree($root);
        $tree->edge($root, $home)
            ->edge($root, $root_file)
            ->edge($home, $file1)
            ->edge($home, $symlink)
            ->edge($home, $documents)
            ->edge($documents, $document_file);

        assert_true([
            $root_file,
            $file1,
            $document_file
        ] == $tree->files()->items());
    }
);
