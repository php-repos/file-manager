<?php

use function PhpRepos\Datatype\Str\assert_equal;
use function PhpRepos\FileManager\Paths\relative_path;
use function PhpRepos\TestRunner\Runner\test;

test(
    title: 'it should return relative path from origin to destination',
    case: function () {
        assert_equal(relative_path('/', '/'), '');
        assert_equal(relative_path('/home', '/home'), '');
        assert_equal(relative_path('/file.php', '/file.php'), '');
        assert_equal(relative_path('/', '/file.php'), 'file.php');
        assert_equal(relative_path('/', '/directory/file.php'), 'directory/file.php');
        assert_equal(relative_path('/file.php', '/'), '..');
        assert_equal(relative_path('/directory/file.php', '/'), '../..');
        assert_equal(relative_path('/file1.php', '/file2.php'), '../file2.php');
        assert_equal(relative_path('/directory/file1.php', '/directory/subdirectory/file2.php'), '../subdirectory/file2.php');
        assert_equal(relative_path('/directory/file1.php', '/directory/file2.php'), '../file2.php');
        assert_equal(relative_path('/directory1/file1.php', '/directory2/file2.php'), '../../directory2/file2.php');
        assert_equal(relative_path('/file1.php', '/subdirectory/file2.php'), '../subdirectory/file2.php');
        assert_equal(relative_path('/file1.php', '/subdirectory/another-subdirectory/file2.php'), '../subdirectory/another-subdirectory/file2.php');
        assert_equal(relative_path('/directory/file1.php', '/file2.php'), '../../file2.php');
        assert_equal(relative_path('/directory/file1.php', '/subdirectory/file2.php'), '../../subdirectory/file2.php');
        assert_equal(relative_path('/Packages/owner/repo/run', '/vendor/autoload.php'), '../../../../vendor/autoload.php');
        assert_equal(relative_path('/home/user/Project/Packages/owner/repo1/Source/Class.php', '/home/user/Project/Packages/owner/repo2/Source/Class.php'), '../../../repo2/Source/Class.php');
    }
);
