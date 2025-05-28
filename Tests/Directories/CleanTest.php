<?php

namespace Tests\Directories\CleanTest;

use function PhpRepos\FileManager\Directories\clean;
use function PhpRepos\FileManager\Paths\append;
use function PhpRepos\FileManager\Paths\root;
use function PhpRepos\TestRunner\Assertions\assert_true;
use function PhpRepos\TestRunner\Runner\test;

test(
    title: 'it should clean directory',
    case: function (string $directory) {
        clean($directory);

        assert_true(file_exists($directory), 'clean is not working!');
        assert_true(
            scandir($directory) === ['.', '..'],
            'clean is not working and there are some items in the directory!'
        );

        return $directory;
    },
    before: function () {
        $directory = append(root(), 'Tests/PlayGround/Clean');
        $subDirectory = append($directory, 'SubDirectory');
        mkdir($directory);
        mkdir($subDirectory);
        file_put_contents(append($directory, 'FileInDirectory.php'), '<?php');

        return $directory;
    },
    after: function (string $directory) {
        rmdir($directory);
    }
);
