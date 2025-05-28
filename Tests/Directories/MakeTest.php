<?php

namespace Tests\Directories\makeTest;

use PhpRepos\FileManager\Directories;
use function PhpRepos\FileManager\Paths\append;
use function PhpRepos\FileManager\Paths\root;
use function PhpRepos\TestRunner\Assertions\assert_true;
use function PhpRepos\TestRunner\Runner\test;

test(
    title: 'it should make a directory',
    case: function () {
        $directory = append(root(), 'Tests/PlayGround/MakeDirectory');

        assert_true(Directories\make($directory));
        assert_true(Directories\exists($directory));
        assert_true(0775 === Directories\permission($directory));

        return $directory;
    },
    after: function (string $address) {
        Directories\delete($address);
    }
);

test(
    title: 'it should make a directory with the given permission',
    case: function () {
        $directory = append(root(), 'Tests/PlayGround/MakeDirectory');

        assert_true(Directories\make($directory, 0777));
        assert_true(Directories\exists($directory));
        assert_true(0777 === Directories\permission($directory));

        return $directory;
    },
    after: function (string $address) {
        Directories\delete($address);
    }
);
