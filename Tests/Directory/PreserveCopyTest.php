<?php

namespace Tests\Directory\PreserveCopyTest;

use PhpRepos\FileManager\Path;
use PhpRepos\FileManager\Directory;
use function PhpRepos\FileManager\Resolver\root;
use function PhpRepos\TestRunner\Assertions\assert_true;
use function PhpRepos\TestRunner\Runner\test;

test(
    title: 'it should copy directory by preserving permission',
    case: function (Path $origin, Path $destination) {
        $copied_directory = $destination->append($origin->leaf());
        assert_true(Directory\preserve_copy($origin, $copied_directory));
        assert_true(Directory\exists($copied_directory));
        assert_true(Directory\permission($origin) === Directory\permission($copied_directory));

        return [$origin, $destination];
    },
    before: function () {
        $origin = Path::from_string(root() . 'Tests/PlayGround/Origin/PreserveCopy');
        Directory\make_recursive($origin);
        $destination = Path::from_string(root() . 'Tests/PlayGround/Destination');
        Directory\make($destination);

        return [$origin, $destination];
    },
    after: function (Path $origin, Path $destination) {
        Directory\delete_recursive($origin->parent());
        Directory\delete_recursive($destination);
    }
);

test(
    title: 'it should copy directory by preserving permission with any permission',
    case: function (Path $origin, Path $destination) {
        $copied_directory = $destination->append($origin->leaf());
        assert_true(Directory\preserve_copy($origin, $copied_directory));
        assert_true(Directory\exists($copied_directory));
        assert_true(0777 === Directory\permission($copied_directory));

        return [$origin, $destination];
    },
    before: function () {
        $origin = Path::from_string(root() . 'Tests/PlayGround/Origin/PreserveCopy');
        Directory\make_recursive($origin, 0777);
        $destination = Path::from_string(root() . 'Tests/PlayGround/Destination');
        Directory\make($destination);

        return [$origin, $destination];
    },
    after: function (Path $origin, Path $destination) {
        Directory\delete_recursive($origin->parent());
        Directory\delete_recursive($destination);
    }
);
