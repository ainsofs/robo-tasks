<?php

use Ainsofs\RoboTasks\TagManager;
use Robo\Tasks;

class RoboFile extends Tasks
{
    /**
     * Create a new Git tag by incrementing the latest tag.
     *
     * @param string $increment The part of the version to increment (patch, minor, major).
     */
    public function createTag($increment = 'patch')
    {
        $tagManager = new TagManager();
        $tagManager->createTag($increment);
    }
}

