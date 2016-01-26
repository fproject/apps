<?php

namespace OCA\PkDrive;

use OC\Files\FileInfo;
use OCA\PkDrive\Component\TargetType;
use OCA\PkDrive\Controller\PageController;

class Helper extends \OCA\Files\Helper
{
    public static function getFiles($dir, $sortAttribute = 'name', $sortDescending = false, $mimetypeFilter = '') {
        $contents = \OC\Files\Filesystem::getDirectoryContent($dir, $mimetypeFilter);

        if(isset($_SESSION['targetType']) && $_SESSION['targetType'] == TargetType::PROJECT) {
            /** @var FileInfo[] $subContents */
            $subContents = [];
            foreach($contents as $content) {
                /** @var FileInfo $content */
                if($content && $content->getMimetype() === 'httpd/unix-directory' ) {
                    $subDir = $dir . "/" . $content->getName();
                    $subContents = array_merge($subContents, \OC\Files\Filesystem::getDirectoryContent($subDir, $mimetypeFilter));
                }
            }
        }

        if(isset($subContents) && count($subContents) != 0) {
            $contents = array_merge($contents, $subContents);
        }

        $excludeFolder = [];
        foreach($contents as $content) {
            /** @var FileInfo $content */
            if($content && $content->getMimetype() === 'httpd/unix-directory' )
                continue;
            array_push($excludeFolder, $content);
        }
        return self::sortFiles($excludeFolder, $sortAttribute, $sortDescending);
    }

    /**
     * Format file info for JSON
     * @param \OCP\Files\FileInfo[] $fileInfos files info
     * @return array
     */
    public static function formatFileInfos($fileInfos) {
        $files = array();
        foreach ($fileInfos as $i) {
            $files[] = self::formatFileInfo($i);
        }
        return $files;
    }

    /**
     * Formats the file info to be returned as JSON to the client.
     *
     * @param \OCP\Files\FileInfo $i
     * @return array formatted file info
     */
    public static function formatFileInfo(FileInfo $i) {
        $entry = parent::formatFileInfo($i);

        preg_match('/(?<container>project-\d+)/', $i->getPath(), $container);
        preg_match('/(?<target>task-(?<targetId>\d+))/', $i->getPath(), $task);
        preg_match('/(?<target>issue-(?<targetId>\d+))/', $i->getPath(), $issue);

        if(!is_null($container)) {
            $entry['path'] .= PageController::PROJECTKIT_PREFIX . DIRECTORY_SEPARATOR .
                $container[0] . DIRECTORY_SEPARATOR;
            if(!empty($task)) {
                $entry['path'] .= $task['target'];
                $entry['targetType'] = TargetType::TASK;
                $entry['targetId'] = $task['targetId'];
            }

            if(!empty($issue)) {
                $entry['path'] .= $issue['target'];
                $entry['targetType'] = TargetType::ISSUE;
                $entry['targetId'] = $issue['targetId'];
            }
        }
        return $entry;
    }
}