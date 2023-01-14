<?php

namespace Tests\Directory\ExistsTest;

use PhpRepos\FileManager\Path;
use function PhpRepos\FileManager\Resolver\root;
use function PhpRepos\FileManager\Directory\delete;
use function PhpRepos\FileManager\Directory\delete_recursive;
use function PhpRepos\FileManager\Directory\exists;
use function PhpRepos\TestRunner\Assertions\Boolean\assert_true;
use function PhpRepos\TestRunner\Assertions\Boolean\assert_false;
use function PhpRepos\TestRunner\Runner\test;

test(
    title: 'it should return false when directory is not exists',
    case: function () {
        $directory = Path::from_string(root() . 'Tests/PlayGround/Exists');
        assert_false(exists($directory), 'Directory/exists is not working!');
    }
);

test(
    title: 'it should return false when given path is a file',
    case: function (Path $directory) {
        assert_false(exists($directory), 'Directory/exists is not working!');

        return $directory;
    },
    before: function () {
        $directory = Path::from_string(root() . 'Tests/PlayGround/Exists');

        file_put_contents($directory, 'A file with directory name');

        return $directory;
    },
    after: function (Path $directory) {
        unlink($directory);
    }
);

test(
    title: 'it should return true when directory is exist and is a directory',
    case: function (Path $directory) {
        assert_true(exists($directory), 'Directory/exists is not working!');

        return $directory;
    },
    before: function () {
        $directory = Path::from_string(root() . 'Tests/PlayGround/Exists');
        mkdir($directory);

        return $directory;
    },
    after: function (Path $directory) {
        delete_recursive($directory);
    }
);

test(
    title: 'it should not return cached value',
    case: function (Path $directory) {
        assert_true(exists($directory), 'Directory/exists is not working!');
        delete($directory);
        assert_false(exists($directory), 'Directory/exists is not working!');
    },
    before: function () {
        $directory = Path::from_string(root() . 'Tests/PlayGround/Exists');
        mkdir($directory);

        return $directory;
    }
);
