<?php

namespace Tests\FileType\Json\WriteTest;

use PhpRepos\FileManager\Path;
use function PhpRepos\FileManager\Resolver\root;
use function PhpRepos\FileManager\Directory\clean;
use function PhpRepos\FileManager\FileType\Json\to_array;
use function PhpRepos\FileManager\FileType\Json\write;
use function PhpRepos\TestRunner\Assertions\Boolean\assert_true;
use function PhpRepos\TestRunner\Runner\test;

test(
    title: 'it should write associated array to json file',
    case: function () {
        $file = Path::from_string(root() . 'Tests/PlayGround/File');
        write($file, ['foo' => 'bar']);
        assert_true(['foo' => 'bar'] === to_array($file));

        return $file;
    },
    after: function (Path $file) {
        clean($file->parent());
    }
);
