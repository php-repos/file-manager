<?php

namespace Tests\Directory\DeleteRecursiveTest;

use PhpRepos\FileManager\Path;
use function PhpRepos\FileManager\Resolver\root;
use function PhpRepos\FileManager\Directory\delete_recursive;
use function PhpRepos\TestRunner\Assertions\assert_true;
use function PhpRepos\TestRunner\Assertions\assert_false;
use function PhpRepos\TestRunner\Runner\test;

test(
    title: 'it should delete directory when it is empty',
    case: function (Path $directory) {
        assert_true(delete_recursive($directory));
        assert_false(file_exists($directory), 'delete_recursive is not working!');
    },
    before: function () {
        $directory = Path::from_string(root() . 'Tests/PlayGround/DeleteRecursive');
        mkdir($directory);

        return $directory;
    }
);

test(
    title: 'it should delete directory recursively',
    case: function (Path $directory) {
        assert_true(delete_recursive($directory));

        assert_true(false === file_exists($directory), 'delete_recursive is not working!');
    },
    before: function () {
        $directory = Path::from_string(root() . 'Tests/PlayGround/DeleteRecursive');
        $sub_directory = $directory->append('SubDirectory');
        $another_sub_directory = $directory->append('SubDirectory/AnotherSubDirectory');
        mkdir($directory);
        mkdir($sub_directory);
        mkdir($another_sub_directory);
        file_put_contents($directory->append('FileInDirectory.php'), '<?php');
        file_put_contents($sub_directory->append('FileInSubDirectory.txt'), 'content');
        file_put_contents($another_sub_directory->append('FileInAnotherSubDirectory.json'), '');

        return $directory;
    }
);
