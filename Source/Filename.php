<?php

namespace PhpRepos\FileManager;

use PhpRepos\Datatype\Text;

class Filename extends Text
{
    public function __construct(string $init)
    {
        parent::__construct($init);
    }
}
