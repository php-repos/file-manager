<?php

namespace Tests\Directory\PreserveCopyRecursiveTest;

use PhpRepos\FileManager\Path;
use PhpRepos\FileManager\Directory;
use PhpRepos\FileManager\File;
use function PhpRepos\FileManager\Directory\preserve_copy_recursively;
use function PhpRepos\FileManager\File\exists;
use function PhpRepos\FileManager\File\permission;
use function PhpRepos\FileManager\Resolver\root;
use function PhpRepos\TestRunner\Assertions\Boolean\assert_true;
use function PhpRepos\TestRunner\Runner\test;

test(
    title: 'it should copy directory recursively by preserving permission',
    case: function (Path $origin, Path $destination) {
        $result = preserve_copy_recursively($origin, $destination);

        assert_true($result, 'preserve_copy_recursive is not working!');
        assert_true(Directory\exists($origin));
        assert_true(Directory\exists($destination));
        assert_true(Directory\exists($destination->append('subdirectory')), 'subdirectory not exists');
        assert_true(
            Directory\permission($origin->append('subdirectory'))
            ===
            Directory\permission($destination->append('subdirectory')),
            'subdirectory permission is wrong'
        );
        assert_true(exists($destination->append('filename.txt')), 'file in copied directory not exists');
        assert_true(
            permission($origin->append('filename.txt'))
            ===
            permission($destination->append('filename.txt')),
            'file permission is wrong in copied directory'
        );
        assert_true(exists($destination->append('subdirectory/.another-file')), 'file in subdirectory not exists');
        assert_true(
            permission($origin->append('subdirectory/.another-file'))
            ===
            permission($destination->append('subdirectory/.another-file')),
            'permission for file in subdirectory is wrong'
        );
    },
    before: function () {
        $origin = Path::from_string(root() . 'Tests/PlayGround/Origin');
        Directory\make_recursive($origin);
        File\create($origin->append('filename.txt'), 'content', 0667);
        Directory\make($origin->append('subdirectory'), 0750);
        File\create($origin->append('subdirectory/.another-file'), '', 0666);
        $destination = Path::from_string(root() . 'Tests/PlayGround/Destination');
        Directory\make($destination);

        return [$origin, $destination];
    },
    after: function () {
        Directory\clean(root() . 'Tests/PlayGround');
    }
);
