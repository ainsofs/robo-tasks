<?php

use Ainsofs\RoboTasks\TagManager;
use Robo\Tasks;

class RoboFile extends Tasks
{
    /**
     * Create a new Git tag by incrementing the latest tag.
     *
     * @param string $increment The part of the version to increment (patch, minor, major).
     * @param string|null $drupalVersion Optional specific Drupal version to override.
     */
    public function createTag($increment = 'patch', $drupalVersion = null)
    {
        $tagManager = new TagManager();
        $tagManager->createTag($increment, $drupalVersion);
    }
}

