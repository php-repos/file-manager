<?php

namespace Tests\Directory\CleanTest;

use PhpRepos\FileManager\Path;
use function PhpRepos\FileManager\Directory\clean;
use function PhpRepos\FileManager\Resolver\root;
use function PhpRepos\TestRunner\Assertions\assert_true;
use function PhpRepos\TestRunner\Runner\test;

test(
    title: 'it should clean directory',
    case: function (Path $directory) {
        clean($directory);

        assert_true(file_exists($directory), 'clean is not working!');
        assert_true(
            scandir($directory) === ['.', '..'],
            'clean is not working and there are some items in the directory!'
        );

        return $directory;
    },
    before: function () {
        $directory = Path::from_string(root() . 'Tests/PlayGround/Clean');
        $subDirectory = $directory->append('SubDirectory');
        mkdir($directory);
        mkdir($subDirectory);
        file_put_contents($directory->append('FileInDirectory.php'), '<?php');

        return $directory;
    },
    after: function (Path $directory) {
        rmdir($directory);
    }
);
