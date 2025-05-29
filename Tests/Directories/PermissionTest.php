<?php

namespace Tests\Directories\PermissionTest;

use PhpRepos\FileManager\Directories;
use function PhpRepos\FileManager\Paths\append;
use function PhpRepos\FileManager\Paths\root;
use function PhpRepos\TestRunner\Assertions\assert_true;
use function PhpRepos\TestRunner\Runner\test;

test(
    title: 'it should return directory\'s permission',
    case: function () {
        $playGround = append(root(), 'Tests/PlayGround');
        $regular = append($playGround, 'regular');
        Directories\make($regular, 0774);
        assert_true(0774 === Directories\permission($regular));

        $full = append($playGround, 'full');
        Directories\make($full, 0777);
        assert_true(0777 === Directories\permission($full));

        return [$regular, $full];
    },
    after: function (string $regular, string $full) {
        Directories\delete($regular);
        Directories\delete($full);
    }
);

test(
    title: 'it should not return cached permission',
    case: function () {
        $playGround = append(root(), 'Tests/PlayGround');
        $directory = append($playGround, 'regular');
        Directories\make($directory);
        assert_true(0775 === Directories\permission($directory));
        chmod($directory, 0774);
        assert_true(0774 === Directories\permission($directory));

        return $directory;
    },
    after: function (string $directory) {
        Directories\delete($directory);
    }
);
