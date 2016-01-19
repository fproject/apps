<?php

namespace OCA\PkDrive;

use OC\Files\FileInfo;
use OCA\PkDrive\Component\TargetType;

class Helper extends \OCA\Files\Helper
{
    public static function getFiles($dir, $sortAttribute = 'name', $sortDescending = false, $mimetypeFilter = '') {
        $contents = \OC\Files\Filesystem::getDirectoryContent($dir, $mimetypeFilter);

        if(isset($_SESSION['targetType']) && $_SESSION['targetType'] == TargetType::PROJECT) {
            $subContents = [];
            foreach($contents as $content) {
                /** @var FileInfo $content */
                if($content && $content->getMimetype() === 'httpd/unix-directory' ) {
                    $subDir = $dir . "/" . $content->getName();
                    /** @var FileInfo[] $subContents */
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
}