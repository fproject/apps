<?php

namespace OCA\PkDrive;

use OC\Files\FileInfo;

class Helper extends \OCA\Files\Helper
{
    public static function getFiles($dir, $sortAttribute = 'name', $sortDescending = false, $mimetypeFilter = '') {
        $contents = \OC\Files\Filesystem::getDirectoryContent($dir, $mimetypeFilter);
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