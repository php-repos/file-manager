<?php

namespace Tests\Resolver\RealpathTest;

use function PhpRepos\FileManager\Resolver\realpath;
use function PhpRepos\TestRunner\Assertions\Boolean\assert_true;
use function PhpRepos\TestRunner\Runner\test;

test(
    title: 'it should return real path for the given path',
    case: function () {
        assert_true(
            DIRECTORY_SEPARATOR . 'user' . DIRECTORY_SEPARATOR . 'home'
            ===
            realpath('/user/home            ')
        );

        assert_true(
            DIRECTORY_SEPARATOR . 'user' . DIRECTORY_SEPARATOR . 'home'
            ===
            realpath('           /user/home            ')
        );
        assert_true(
            DIRECTORY_SEPARATOR . 'user' . DIRECTORY_SEPARATOR . 'home' . DIRECTORY_SEPARATOR . 'directory' . DIRECTORY_SEPARATOR . 'filename.extension'
            ===
            realpath('/user/home/./directory/filename.extension')
        );

        assert_true(
            DIRECTORY_SEPARATOR . 'user' . DIRECTORY_SEPARATOR . 'home' . DIRECTORY_SEPARATOR . 'directory' . DIRECTORY_SEPARATOR . 'filename.extension'
            ===
            realpath('/user/home/./directory/another-directory/../filename.extension')
        );

        assert_true(
            DIRECTORY_SEPARATOR . 'user' . DIRECTORY_SEPARATOR . 'home' . DIRECTORY_SEPARATOR . 'directory' . DIRECTORY_SEPARATOR . 'filename.extension'
            ===
            realpath('/user/home\\\\/./directory///another-directory//../filename.extension')
        );

        assert_true(
            DIRECTORY_SEPARATOR . 'user' . DIRECTORY_SEPARATOR . 'filename.extension'
            ===
            realpath('/user/home/directory/../../filename.extension')
        );

        assert_true(
            DIRECTORY_SEPARATOR . 'user' . DIRECTORY_SEPARATOR . 'home' . DIRECTORY_SEPARATOR . 'directory'
            ===
            realpath('\user\home/directory')
        );

        assert_true(
            DIRECTORY_SEPARATOR . 'user' . DIRECTORY_SEPARATOR . 'home' . DIRECTORY_SEPARATOR . 'directory'
            ===
            realpath('\user\\\\home////directory')
        );

        assert_true(
            DIRECTORY_SEPARATOR . 'user' . DIRECTORY_SEPARATOR . 'home' . DIRECTORY_SEPARATOR . 'directory'
            ===
            realpath('\user\\\\home////directory\\')
        );

        assert_true(
            DIRECTORY_SEPARATOR . 'user' . DIRECTORY_SEPARATOR . 'directory'
            ===
            realpath('\user\home\..\directory')
        );

        assert_true(
            DIRECTORY_SEPARATOR . 'user' . DIRECTORY_SEPARATOR . 'directory'
            ===
            realpath('\user\home\.././directory')
        );

        assert_true(DIRECTORY_SEPARATOR === realpath('/'));
    }
);
