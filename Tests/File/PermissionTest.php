<?php

namespace Tests\File\PermissionTest;

use PhpRepos\FileManager\Files;
use function PhpRepos\FileManager\Paths\append;
use function PhpRepos\FileManager\Paths\root;
use function PhpRepos\TestRunner\Assertions\assert_true;
use function PhpRepos\TestRunner\Runner\test;

test(
    title: 'it should return file\'s permission',
    case: function () {
        $playGround = append(root(), 'Tests/PlayGround');
        $regular = append($playGround, 'regular');
        Files\create($regular, 'content');
        chmod($regular, 0664);
        assert_true(0664 === Files\permission($regular));

        $full = append($playGround, 'full');
        umask(0);
        Files\create($full, 'full');
        chmod($full, 0777);
        assert_true(0777 === Files\permission($full));

        return [$regular, $full];
    },
    after: function (string $regular, string $full) {
        Files\delete($regular);
        Files\delete($full);
    }
);

test(
    title: 'it should not return cached permission',
    case: function () {
        $playGround = append(root(), 'Tests/PlayGround');
        $file = append($playGround, 'regular');
        Files\create($file, 0775);
        umask(0);
        chmod($file, 0777);
        assert_true(0777 === Files\permission($file));
        chmod($file, 0666);
        assert_true(0666 === Files\permission($file));

        return $file;
    },
    after: function (string $file) {
        Files\delete($file);
    }
);
