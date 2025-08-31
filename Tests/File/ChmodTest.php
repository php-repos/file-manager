<?php


use PhpRepos\FileManager\Files;
use function PhpRepos\FileManager\Paths\append;
use function PhpRepos\FileManager\Paths\root;
use function PhpRepos\TestRunner\Assertions\assert_true;
use function PhpRepos\TestRunner\Runner\test;

test(
    title: 'it should change file\'s permission',
    case: function () {
        $playGround = append(root(), 'Tests/PlayGround');
        $regular = append($playGround, 'regular');
        Files\create($regular, 'content');
        assert_true(Files\chmod($regular, 0664));
        assert_true(0664 === Files\permission($regular));

        $full = append($playGround, 'full');
        Files\create($full, 'full');
        assert_true(Files\chmod($full, 0777));
        assert_true(0777 === Files\permission($full));

        return [$regular, $full];
    },
    after: function (string $regular, string $full) {
        Files\delete($regular);
        Files\delete($full);
    }
);
