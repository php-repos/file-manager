<?php

namespace Tests\Directory\ChmodTest;

use PhpRepos\FileManager\Path;
use PhpRepos\FileManager\Directory;
use function PhpRepos\FileManager\Resolver\root;
use function PhpRepos\TestRunner\Assertions\assert_true;
use function PhpRepos\TestRunner\Runner\test;

test(
    title: 'it should change directory\'s permission',
    case: function () {
        $playGround = Path::from_string(root() . 'Tests/PlayGround');
        $regular = $playGround->append('regular');
        Directory\make($regular, 0666);
        assert_true(Directory\chmod($regular, 0774));
        assert_true(0774 === Directory\permission($regular));

        $full = $playGround->append('full');
        Directory\make($full, 0755);
        assert_true(Directory\chmod($full, 0777));
        assert_true(0777 === Directory\permission($full));

        return [$regular, $full];
    },
    after: function (Path $regular, Path $full) {
        Directory\delete($regular);
        Directory\delete($full);
    }
);
