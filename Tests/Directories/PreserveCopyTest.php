<?php

namespace Tests\Directories\PreserveCopyTest;

use PhpRepos\FileManager\Directories;
use function PhpRepos\FileManager\Paths\append;
use function PhpRepos\FileManager\Paths\filename;
use function PhpRepos\FileManager\Paths\parent;
use function PhpRepos\FileManager\Paths\root;
use function PhpRepos\TestRunner\Assertions\assert_true;
use function PhpRepos\TestRunner\Runner\test;

test(
    title: 'it should copy directory by preserving permission',
    case: function (string $origin, string $destination) {
        $copied_directory = append($destination, filename($origin));
        assert_true(Directories\preserve_copy($origin, $copied_directory));
        assert_true(Directories\exists($copied_directory));
        assert_true(Directories\permission($origin) === Directories\permission($copied_directory));

        return [$origin, $destination];
    },
    before: function () {
        $origin = append(root(), 'Tests/PlayGround/Origin/PreserveCopy');
        Directories\make_recursive($origin);
        $destination = append(root(), 'Tests/PlayGround/Destination');
        Directories\make($destination);

        return [$origin, $destination];
    },
    after: function (string $origin, string $destination) {
        Directories\delete_recursive(parent($origin));
        Directories\delete_recursive($destination);
    }
);

test(
    title: 'it should copy directory by preserving permission with any permission',
    case: function (string $origin, string $destination) {
        $copied_directory = append($destination, filename($origin));
        assert_true(Directories\preserve_copy($origin, $copied_directory));
        assert_true(Directories\exists($copied_directory));
        assert_true(0777 === Directories\permission($copied_directory));

        return [$origin, $destination];
    },
    before: function () {
        $origin = append(root(), 'Tests/PlayGround/Origin/PreserveCopy');
        Directories\make_recursive($origin, 0777);
        $destination = append(root(), 'Tests/PlayGround/Destination');
        Directories\make($destination);

        return [$origin, $destination];
    },
    after: function (string $origin, string $destination) {
        Directories\delete_recursive(parent($origin));
        Directories\delete_recursive($destination);
    }
);
