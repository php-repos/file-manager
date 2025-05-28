<?php

namespace Tests\Directories\DeleteRecursiveTest;

use function PhpRepos\FileManager\Paths\append;
use function PhpRepos\FileManager\Paths\root;
use function PhpRepos\FileManager\Directories\delete_recursive;
use function PhpRepos\TestRunner\Assertions\assert_true;
use function PhpRepos\TestRunner\Assertions\assert_false;
use function PhpRepos\TestRunner\Runner\test;

test(
    title: 'it should delete directory when it is empty',
    case: function (string $directory) {
        assert_true(delete_recursive($directory));
        assert_false(file_exists($directory), 'delete_recursive is not working!');
    },
    before: function () {
        $directory = append(root(), 'Tests/PlayGround/DeleteRecursive');
        mkdir($directory);

        return $directory;
    }
);

test(
    title: 'it should delete directory recursively',
    case: function (string $directory) {
        assert_true(delete_recursive($directory));

        assert_true(false === file_exists($directory), 'delete_recursive is not working!');
    },
    before: function () {
        $directory = append(root(), 'Tests/PlayGround/DeleteRecursive');
        $sub_directory = append($directory, 'SubDirectory');
        $another_sub_directory = append($directory, 'SubDirectory/AnotherSubDirectory');
        mkdir($directory);
        mkdir($sub_directory);
        mkdir($another_sub_directory);
        file_put_contents(append($directory, 'FileInDirectory.php'), '<?php');
        file_put_contents(append($sub_directory, 'FileInSubDirectory.txt'), 'content');
        file_put_contents(append($another_sub_directory, 'FileInAnotherSubDirectory.json'), '');

        return $directory;
    }
);
