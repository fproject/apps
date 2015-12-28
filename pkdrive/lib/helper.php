<?php

namespace OCA\PkDrive;


class Helper extends \OCA\Files\Helper
{
    public static function getFiles($dir, $sortAttribute = 'name', $sortDescending = false, $mimetypeFilter = '') {
        $content = \OC\Files\Filesystem::getDirectoryContent($dir, $mimetypeFilter);
        $test = 1;
        return self::sortFiles($content, $sortAttribute, $sortDescending);
    }
}