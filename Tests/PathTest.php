<?php

namespace Tests\PathTest;

use PhpRepos\FileManager\Path;
use function PhpRepos\TestRunner\Assertions\Boolean\assert_true;
use function PhpRepos\TestRunner\Assertions\Boolean\assert_false;
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
    title: 'it should append and return a new path instance',
    case: function () {
        $path = Path::from_string('/user/home');
        assert_true($path->append('directory') instanceof Path);
        assert_true(
            DIRECTORY_SEPARATOR . 'user' . DIRECTORY_SEPARATOR . 'home' . DIRECTORY_SEPARATOR . 'directory'
            ===
            $path->append('directory')->string()
            &&
            DIRECTORY_SEPARATOR . 'user' . DIRECTORY_SEPARATOR . 'home'
            ===
            $path->string()
        );

        assert_true(
            DIRECTORY_SEPARATOR . 'user' . DIRECTORY_SEPARATOR . 'home' . DIRECTORY_SEPARATOR . 'directory'
            ===
            Path::from_string('/user/home')->append('\directory')->string()
        );

        assert_true(
            DIRECTORY_SEPARATOR . 'user' . DIRECTORY_SEPARATOR . 'home' . DIRECTORY_SEPARATOR . 'directory'
            ===
            Path::from_string('/user/home')->append('\directory\\')->string()
        );

        assert_true(
            DIRECTORY_SEPARATOR . 'user' . DIRECTORY_SEPARATOR . 'home' . DIRECTORY_SEPARATOR . 'directory' . DIRECTORY_SEPARATOR . 'filename.extension'
            ===
            Path::from_string('\user/home')->append('directory\filename.extension')->string()
        );

        assert_true(
            DIRECTORY_SEPARATOR . 'user' . DIRECTORY_SEPARATOR . 'home' . DIRECTORY_SEPARATOR . 'directory' . DIRECTORY_SEPARATOR . 'filename.extension'
            ===
            Path::from_string('\user/home')->append('directory\filename.extension/')->string()
        );

        assert_true(
            DIRECTORY_SEPARATOR . 'user' . DIRECTORY_SEPARATOR . 'home' . DIRECTORY_SEPARATOR . 'directory' . DIRECTORY_SEPARATOR . 'filename.extension'
            ===
            Path::from_string('\user////home')->append('directory\\\\filename.extension')->string()
        );

        assert_true(
            DIRECTORY_SEPARATOR . 'user' . DIRECTORY_SEPARATOR . 'directory' . DIRECTORY_SEPARATOR . 'filename.extension'
            ===
            Path::from_string('\user/home/..\./')->append('./another-directory/../directory\\\\filename.extension')->string()
        );
    }
);

test(
    title: 'it should return new instance of parent directory for the given path',
    case: function () {
        $path = Path::from_string('/user/home/directory/filename.extension');

        assert_true(
            $path->parent() instanceof Path
            &&
            DIRECTORY_SEPARATOR . 'user' . DIRECTORY_SEPARATOR . 'home' . DIRECTORY_SEPARATOR . 'directory'
            ===
            $path->parent()->string()
            &&
            DIRECTORY_SEPARATOR . 'user' . DIRECTORY_SEPARATOR . 'home' . DIRECTORY_SEPARATOR . 'directory' . DIRECTORY_SEPARATOR . 'filename.extension'
            ===
            $path->string()
        );
    }
);

test(
    title: 'it should detect the leaf',
    case: function () {
        assert_true(Path::from_string('/')->string() === Path::from_string('/')->leaf()->string(), 'root leaf is not detected');
        assert_true('PathTest.php' === Path::from_string(__FILE__)->leaf()->string(), 'leaf for file is not detected');
        assert_true('Tests' === Path::from_string(__DIR__)->leaf()->string(), 'leaf for directory is not detected');
    }
);

test(
    title: 'it should return sibling',
    case: function () {
        $address = Path::from_string('/root/user/home/item');
        $sibling = $address->sibling('sibling');

        assert_true($sibling instanceof Path);
        assert_true($address->parent()->append('sibling')->string() === $sibling->string());
    }
);

test(
    title: 'it should relocate path directory',
    case: function () {
        $path = new Path('/home/user1/directory/filename');
        $relocate = $path->relocate('/home/user1/directory', '/home/user2/directory/../another-directory');

        assert_true($relocate instanceof Path);
        assert_true('/home/user2/another-directory/filename');
    }
);
