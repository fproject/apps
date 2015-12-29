<?php
/**
 * ownCloud - pkdrive
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 *
 * @author Phan Van Thanh <thanhpv@fimo.du.[3~[3~>
 * @copyright Phan Van Thanh 2015
 */

/**
 * Create your routes in here. The name is the lowercase name of the controller
 * without the controller part, the stuff after the hash is the method.
 * e.g. page#index -> OCA\PkDrive\Controller\PageController->index()
 *
 * The controller class has to be registered in the application.php file since
 * it's instantiated in there
 */

$this->create('files_ajax_delete', 'ajax/delete.php')
	->actionInclude('pkdrive/ajax/delete.php');
$this->create('files_ajax_download', 'ajax/download.php')
	->actionInclude('pkdrive/ajax/download.php');
$this->create('files_ajax_getstoragestats', 'ajax/getstoragestats.php')
	->actionInclude('pkdrive/ajax/getstoragestats.php');
$this->create('files_ajax_list', 'ajax/list.php')
	->actionInclude('pkdrive/ajax/list.php');
$this->create('files_ajax_move', 'ajax/move.php')
	->actionInclude('pkdrive/ajax/move.php');
$this->create('files_ajax_rename', 'ajax/rename.php')
	->actionInclude('pkdrive/ajax/rename.php');
$this->create('files_ajax_scan', 'ajax/scan.php')
	->actionInclude('pkdrive/ajax/scan.php');
$this->create('files_ajax_upload', 'ajax/upload.php')
	->actionInclude('pkdrive/ajax/upload.php');

$this->create('download', 'download{file}')
	->requirements(array('file' => '.*'))
	->actionInclude('pkdrive/download.php');

return [
    'routes' => [
	   ['name' => 'page#index', 'url' => '/', 'verb' => 'GET'],
	   ['name' => 'page#do_echo', 'url' => '/echo', 'verb' => 'POST'],
    ]
];