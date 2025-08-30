<?php


use function PhpRepos\FileManager\Paths\append;
use function PhpRepos\FileManager\Paths\root;
use function PhpRepos\FileManager\Directories\delete;
use function PhpRepos\FileManager\Directories\delete_recursive;
use function PhpRepos\FileManager\Directories\exists;
use function PhpRepos\TestRunner\Assertions\assert_true;
use function PhpRepos\TestRunner\Assertions\assert_false;
use function PhpRepos\TestRunner\Runner\test;

test(
    title: 'it should return false when directory is not exists',
    case: function () {
        $directory = append(root(), 'Tests/PlayGround/Exists');
        assert_false(exists($directory), 'Directory/exists is not working!');
    }
);

test(
    title: 'it should return false when given path is a file',
    case: function (string $directory) {
        assert_false(exists($directory), 'Directory/exists is not working!');

        return $directory;
    },
    before: function () {
        $directory = append(root(), 'Tests/PlayGround/Exists');

        file_put_contents($directory, 'A file with directory name');

        return $directory;
    },
    after: function (string $directory) {
        unlink($directory);
    }
);

test(
    title: 'it should return true when directory is exist and is a directory',
    case: function (string $directory) {
        assert_true(exists($directory), 'Directory/exists is not working!');

        return $directory;
    },
    before: function () {
        $directory = append(root(), 'Tests/PlayGround/Exists');
        mkdir($directory);

        return $directory;
    },
    after: function (string $directory) {
        delete_recursive($directory);
    }
);

test(
    title: 'it should not return cached value',
    case: function (string $directory) {
        assert_true(exists($directory), 'Directory/exists is not working!');
        delete($directory);
        assert_false(exists($directory), 'Directory/exists is not working!');
    },
    before: function () {
        $directory = append(root(), 'Tests/PlayGround/Exists');
        mkdir($directory);

        return $directory;
    }
);
