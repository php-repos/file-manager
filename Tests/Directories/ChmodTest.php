<?php

namespace Tests\Directories\ChmodTest;

use PhpRepos\FileManager\Directories;
use function PhpRepos\FileManager\Paths\append;
use function PhpRepos\FileManager\Paths\root;
use function PhpRepos\TestRunner\Assertions\assert_true;
use function PhpRepos\TestRunner\Runner\test;

test(
    title: 'it should change directory\'s permission',
    case: function () {
        $playGround = append(root(),  'Tests/PlayGround');
        $regular = append($playGround, 'regular');
        Directories\make($regular, 0666);
        assert_true(Directories\chmod($regular, 0774));
        assert_true(0774 === Directories\permission($regular));

        $full = append($playGround, 'full');
        Directories\make($full, 0755);
        assert_true(Directories\chmod($full, 0777));
        assert_true(0777 === Directories\permission($full));

        return [$regular, $full];
    },
    after: function (string $regular, string $full) {
        Directories\delete($regular);
        Directories\delete($full);
    }
);
