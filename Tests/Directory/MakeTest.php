<?php

namespace Tests\Directory\makeTest;

use PhpRepos\FileManager\Path;
use PhpRepos\FileManager\Directory;
use function PhpRepos\FileManager\Resolver\root;
use function PhpRepos\TestRunner\Assertions\assert_true;
use function PhpRepos\TestRunner\Runner\test;

test(
    title: 'it should make a directory',
    case: function () {
        $directory = Path::from_string(root() . 'Tests/PlayGround/MakeDirectory');

        assert_true(Directory\make($directory));
        assert_true(Directory\exists($directory));
        assert_true(0775 === Directory\permission($directory));

        return $directory;
    },
    after: function (Path $address) {
        Directory\delete($address);
    }
);

test(
    title: 'it should make a directory with the given permission',
    case: function () {
        $directory = Path::from_string(root() . 'Tests/PlayGround/MakeDirectory');

        assert_true(Directory\make($directory, 0777));
        assert_true(Directory\exists($directory));
        assert_true(0777 === Directory\permission($directory));

        return $directory;
    },
    after: function (Path $address) {
        Directory\delete($address);
    }
);
