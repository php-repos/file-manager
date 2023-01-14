<?php

namespace Tests\File\PermissionTest;

use PhpRepos\FileManager\Path;
use PhpRepos\FileManager\File;
use function PhpRepos\FileManager\Resolver\root;
use function PhpRepos\TestRunner\Assertions\Boolean\assert_true;
use function PhpRepos\TestRunner\Runner\test;

test(
    title: 'it should return file\'s permission',
    case: function () {
        $playGround = Path::from_string(root() . 'Tests/PlayGround');
        $regular = $playGround->append('regular');
        File\create($regular, 'content');
        chmod($regular, 0664);
        assert_true(0664 === File\permission($regular));

        $full = $playGround->append('full');
        umask(0);
        File\create($full, 'full');
        chmod($full, 0777);
        assert_true(0777 === File\permission($full));

        return [$regular, $full];
    },
    after: function (Path $regular, Path $full) {
        File\delete($regular);
        File\delete($full);
    }
);

test(
    title: 'it should not return cached permission',
    case: function () {
        $playGround = Path::from_string(root() . 'Tests/PlayGround');
        $file = $playGround->append('regular');
        File\create($file, 0775);
        umask(0);
        chmod($file, 0777);
        assert_true(0777 === File\permission($file));
        chmod($file, 0666);
        assert_true(0666 === File\permission($file));

        return $file;
    },
    after: function (Path $file) {
        File\delete($file);
    }
);
