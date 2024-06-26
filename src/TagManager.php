<?php

namespace Ainsofs\RoboTasks;

class TagManager
{
    public function createTag($increment = 'patch', $overrideDrupalVersion = null)
    {
        if ($this->hasTagForLatestCommit()) {
            echo "A tag already exists for the latest commit. No new tag will be created.\n";
            return;
        }

        $latestTag = $this->getLatestTag();

        if (!$latestTag) {
            echo "No tags found in the repository.\n";
            return;
        }

        list($drupalVersion, $appVersion) = explode('-', $latestTag);

        if ($overrideDrupalVersion !== null) {
            $drupalVersion = $overrideDrupalVersion;
        }

        $newAppVersion = $this->incrementVersion($appVersion, $increment);
        $newTag = "$drupalVersion-$newAppVersion";

        exec("git tag $newTag", $output, $return_var);

        if ($return_var === 0) {
            echo "New tag created: $newTag\n";
        } else {
            echo "Failed to create new tag.\n";
        }
    }

    protected function getLatestTag()
    {
        $output = [];
        exec('git tag --sort=-creatordate | head -n 1', $output);

        return $output[0] ?? null;
    }

    protected function incrementVersion($version, $part)
    {
        list($major, $minor, $patch) = array_map('intval', explode('.', $version));

        switch ($part) {
            case 'patch':
                $patch++;
                break;
            case 'minor':
                $minor++;
                $patch = 0;
                break;
            case 'major':
                $major++;
                $minor = 0;
                $patch = 0;
                break;
        }

        return "$major.$minor.$patch";
    }

    protected function hasTagForLatestCommit()
    {
        exec('git describe --exact-match HEAD', $output, $return_var);
        return $return_var === 0;
    }
}

