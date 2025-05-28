<?php

namespace Tests\Directories\PreserveCopyRecursiveTest;

use PhpRepos\FileManager\Directories;
use PhpRepos\FileManager\Files;
use function PhpRepos\FileManager\Directories\preserve_copy_recursively;
use function PhpRepos\FileManager\Files\exists;
use function PhpRepos\FileManager\Files\permission;
use function PhpRepos\FileManager\Paths\append;
use function PhpRepos\FileManager\Paths\root;
use function PhpRepos\TestRunner\Assertions\assert_true;
use function PhpRepos\TestRunner\Runner\test;

test(
    title: 'it should copy directory recursively by preserving permission',
    case: function (string $origin, string $destination) {
        $result = preserve_copy_recursively($origin, $destination);

        assert_true($result, 'preserve_copy_recursive is not working!');
        assert_true(Directories\exists($origin));
        assert_true(Directories\exists($destination));
        assert_true(Directories\exists(append($destination, 'subdirectory')), 'subdirectory not exists');
        assert_true(
            Directories\permission(append($origin, 'subdirectory'))
            ===
            Directories\permission(append($destination, 'subdirectory')),
            'subdirectory permission is wrong'
        );
        assert_true(exists(append($destination, 'filename.txt')), 'file in copied directory not exists');
        assert_true(
            permission(append($origin, 'filename.txt'))
            ===
            permission(append($destination, 'filename.txt')),
            'file permission is wrong in copied directory'
        );
        assert_true(exists(append($destination, 'subdirectory/.another-file')), 'file in subdirectory not exists');
        assert_true(
            permission(append($origin, 'subdirectory/.another-file'))
            ===
            permission(append($destination, 'subdirectory/.another-file')),
            'permission for file in subdirectory is wrong'
        );
    },
    before: function () {
        $origin = append(root(), 'Tests/PlayGround/Origin');
        Directories\make_recursive($origin);
        Files\create(append($origin, 'filename.txt'), 'content', 0667);
        Directories\make(append($origin, 'subdirectory'), 0750);
        Files\create(append($origin, 'subdirectory/.another-file'), '', 0666);
        $destination = append(root(), 'Tests/PlayGround/Destination');

        return [$origin, $destination];
    },
    after: function () {
        Directories\clean(append(root(), 'Tests/PlayGround'));
    }
);
