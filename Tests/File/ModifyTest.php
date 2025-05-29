<?php

namespace Tests\File\ModifyTest;

use function PhpRepos\FileManager\Paths\append;
use function PhpRepos\FileManager\Paths\root;
use function PhpRepos\FileManager\Files\content;
use function PhpRepos\FileManager\Files\create;
use function PhpRepos\FileManager\Files\modify;
use function PhpRepos\FileManager\Files\delete;
use function PhpRepos\FileManager\Files\exists;
use function PhpRepos\TestRunner\Assertions\assert_true;
use function PhpRepos\TestRunner\Runner\test;

test(
    title: 'it should modify file',
    case: function (string $file) {
        assert_true(modify($file, 'content in file'));
        assert_true(exists($file));
        assert_true('content in file' === content($file));

        return $file;
    },
    before: function () {
        $file = append(root(), 'Tests/PlayGround/sample.txt');
        create($file, 'create content');

        return $file;
    },
    after: function (string $file) {
        delete($file);
    }
);
