<?php


use PhpRepos\FileManager\Path;
use function PhpRepos\Datatype\Str\assert_equal;
use function PhpRepos\TestRunner\Assertions\assert_true;
use function PhpRepos\TestRunner\Runner\test;

test(
    title: 'it should create path from string',
    case: function () {
        assert_true(
            DIRECTORY_SEPARATOR . 'user' . DIRECTORY_SEPARATOR . 'home' . DIRECTORY_SEPARATOR . 'directory'
            ===
            Path::from_string('\user\home/directory     ')->string()
        );

        assert_true(
            DIRECTORY_SEPARATOR . 'user' . DIRECTORY_SEPARATOR . 'home' . DIRECTORY_SEPARATOR . 'directory'
            ===
            Path::from_string('     \user\home/directory     ')->string()
        );

        assert_true(
            DIRECTORY_SEPARATOR . 'user' . DIRECTORY_SEPARATOR . 'home' . DIRECTORY_SEPARATOR . 'directory'
            ===
            Path::from_string('\user\home/directory')->string()
        );

        assert_true(
            DIRECTORY_SEPARATOR . 'user' . DIRECTORY_SEPARATOR . 'home' . DIRECTORY_SEPARATOR . 'directory'
            ===
            Path::from_string('\user\\\\home//directory')->string()
        );

        assert_true(
            DIRECTORY_SEPARATOR . 'user' . DIRECTORY_SEPARATOR . 'home' . DIRECTORY_SEPARATOR . 'directory'
            ===
            Path::from_string('\user\\\\home//directory/')->string()
        );

        assert_true(
            DIRECTORY_SEPARATOR . 'user' . DIRECTORY_SEPARATOR . 'middle-directory' . DIRECTORY_SEPARATOR . 'directory'
            ===
            Path::from_string('\user\home\../middle-directory\directory')->string()
        );

        assert_true(
            DIRECTORY_SEPARATOR . 'user' . DIRECTORY_SEPARATOR . 'middle-directory' . DIRECTORY_SEPARATOR . 'directory'
            ===
            Path::from_string('\user\home\.././middle-directory/directory')->string()
        );
    }
);

test(
    title: 'it should create path by calling from_string method',
    case: function () {
        assert_true(
            DIRECTORY_SEPARATOR . 'user' . DIRECTORY_SEPARATOR . 'home' . DIRECTORY_SEPARATOR . 'directory'
            ===
            Path::from_string('\user\home/directory')->string()
        );

        assert_true(
            DIRECTORY_SEPARATOR . 'user' . DIRECTORY_SEPARATOR . 'home' . DIRECTORY_SEPARATOR . 'directory'
            ===
            Path::from_string('\user\\\\home///directory')->string()
        );

        assert_true(
            DIRECTORY_SEPARATOR . 'user' . DIRECTORY_SEPARATOR . 'home' . DIRECTORY_SEPARATOR . 'directory'
            ===
            Path::from_string('\user\\\\home///directory/')->string()
        );

        assert_true(
            DIRECTORY_SEPARATOR . 'user' . DIRECTORY_SEPARATOR . 'middle-directory' . DIRECTORY_SEPARATOR . 'directory'
            ===
            Path::from_string('\user\home\../middle-directory\directory')->string()
        );

        assert_true(
            DIRECTORY_SEPARATOR . 'user' . DIRECTORY_SEPARATOR . 'middle-directory' . DIRECTORY_SEPARATOR . 'directory'
            ===
            Path::from_string('\user\home\.././middle-directory/directory')->string()
        );
    }
);

test(
    title: 'it should set the path by appending to the given sub',
    case: function () {
        $path = Path::from_string('/user/home');
        assert_equal(DIRECTORY_SEPARATOR . 'user' . DIRECTORY_SEPARATOR . 'home' . DIRECTORY_SEPARATOR . 'directory', $path->sub('directory')->string());
        assert_equal(DIRECTORY_SEPARATOR . 'user' . DIRECTORY_SEPARATOR . 'home' . DIRECTORY_SEPARATOR . 'directory', Path::from_string('/user/home')->sub('\directory')->string());
        assert_equal(DIRECTORY_SEPARATOR . 'user' . DIRECTORY_SEPARATOR . 'home' . DIRECTORY_SEPARATOR . 'directory', Path::from_string('/user/home')->sub('\directory\\')->string());
        assert_equal(DIRECTORY_SEPARATOR . 'user' . DIRECTORY_SEPARATOR . 'home' . DIRECTORY_SEPARATOR . 'directory' . DIRECTORY_SEPARATOR . 'filename.extension', Path::from_string('\user/home')->sub('directory\filename.extension')->string());
        assert_equal(DIRECTORY_SEPARATOR . 'user' . DIRECTORY_SEPARATOR . 'home' . DIRECTORY_SEPARATOR . 'directory' . DIRECTORY_SEPARATOR . 'filename.extension', Path::from_string('\user/home')->sub('directory\filename.extension/')->string());
        assert_equal(DIRECTORY_SEPARATOR . 'user' . DIRECTORY_SEPARATOR . 'home' . DIRECTORY_SEPARATOR . 'directory' . DIRECTORY_SEPARATOR . 'filename.extension', Path::from_string('\user////home')->sub('directory\\\\filename.extension')->string());
        assert_equal(DIRECTORY_SEPARATOR . 'user' . DIRECTORY_SEPARATOR . 'directory' . DIRECTORY_SEPARATOR . 'filename.extension', Path::from_string('\user/home/..\./')->sub('./another-directory/../directory\\\\filename.extension')->string());
    }
);

test(
    title: 'it should relocate path directory',
    case: function () {
        $path = new Path('/home/user1/directory/filename');
        $relocate = $path->relocate('/home/user1/directory', '/home/user2/directory/../another-directory');

        assert_equal($relocate, '/home/user2/another-directory/filename');
    }
);
