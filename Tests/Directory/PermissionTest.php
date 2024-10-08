<?php

namespace Tests\Directory\PermissionTest;

use PhpRepos\FileManager\Path;
use PhpRepos\FileManager\Directory;
use function PhpRepos\FileManager\Resolver\root;
use function PhpRepos\TestRunner\Assertions\assert_true;
use function PhpRepos\TestRunner\Runner\test;

test(
    title: 'it should return directory\'s permission',
    case: function () {
        $playGround = Path::from_string(root() . 'Tests/PlayGround');
        $regular = $playGround->append('regular');
        Directory\make($regular, 0774);
        assert_true(0774 === Directory\permission($regular));

        $full = $playGround->append('full');
        Directory\make($full, 0777);
        assert_true(0777 === Directory\permission($full));

        return [$regular, $full];
    },
    after: function (Path $regular, Path $full) {
        Directory\delete($regular);
        Directory\delete($full);
    }
);

test(
    title: 'it should not return cached permission',
    case: function () {
        $playGround = Path::from_string(root() . 'Tests/PlayGround');
        $directory = $playGround->append('regular');
        Directory\make($directory);
        assert_true(0775 === Directory\permission($directory));
        chmod($directory, 0774);
        assert_true(0774 === Directory\permission($directory));

        return $directory;
    },
    after: function (Path $directory) {
        Directory\delete($directory);
    }
);
