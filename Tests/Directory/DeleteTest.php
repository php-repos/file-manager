<?php

namespace Tests\Directory\DeleteTest;

use PhpRepos\FileManager\Path;
use PhpRepos\FileManager\Directory;
use function PhpRepos\FileManager\Resolver\root;
use function PhpRepos\TestRunner\Assertions\assert_false;
use function PhpRepos\TestRunner\Runner\test;

test(
    title: 'it should delete the given directory',
    case: function (Path $directory) {
        Directory\delete($directory);

        assert_false(Directory\exists($directory));
    },
    before: function () {
        $directory = Path::from_string(root() . 'Tests/PlayGround/DeleteDirectory');
        mkdir($directory);

        return $directory;
    }
);
