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

namespace OCA\PkDrive\Controller;

use OC\Files\Filesystem;
use OCA\PkDrive\Component\TargetType;
use OCP\AppFramework\Http\ContentSecurityPolicy;
use OCP\IRequest;
use OCP\AppFramework\Http\TemplateResponse;
use OCP\AppFramework\Http\DataResponse;
use OCP\AppFramework\Controller;
use OCP\Util;

class PageController extends Controller {

	const PROJECTKIT_PREFIX = 'projectkit';
	const PROJECT_PREFIX = 'project-';
	const TASK_PREFIX = 'task-';
	const ISSUE_PREFIX = 'issue-';

	private $userId;

	public function __construct($AppName, IRequest $request, $UserId){
		parent::__construct($AppName, $request);
		$this->userId = $UserId;
		$path = self::PROJECTKIT_PREFIX . DIRECTORY_SEPARATOR;
		if(isset($_GET['containerId'])) {
			$path .= self::PROJECT_PREFIX . (string)$_GET['containerId'] . DIRECTORY_SEPARATOR;
			if(isset($_GET['targetType']) && isset($_GET['targetId'])) {
				switch($_GET['targetType']) {
					case TargetType::TASK:
						$path .= self::TASK_PREFIX;
						break;
					case TargetType::ISSUE:
						$path .= self::ISSUE_PREFIX;
						break;
					default:
						break;
				}
				$path .= (string)$_GET['targetId'] . DIRECTORY_SEPARATOR;
			} elseif (!isset($_GET['targetType']) && !isset($_GET['targetId']))
				$_SESSION['targetType'] = TargetType::PROJECT; //use session to save targetType

			$path = Filesystem::normalizePath($path);
			//Create folder for path
			if (!Filesystem::file_exists($path)) {
				try {
					Filesystem::mkdir($path);
				} catch (\Exception $e) {
					$result = [
						'success' => false,
						'data' => [
							'message' => $e->getMessage()
						]
					];
					\OCP\JSON::error($result);
					exit();
				}
			}
			if(!isset($_GET['dir'])) {
				$params = array_merge($_GET, ["dir" => $path]);
				$url = $_SERVER['PHP_SELF'] . '?' . http_build_query($params);
				header('Location: ' . $url, true, 302);
				exit();
			}
		}
	}

	/**
	 * CAUTION: the @Stuff turns off security checks; for this page no admin is
	 *          required and no CSRF check. If you don't know what CSRF is, read
	 *          it up in the docs or you might create a security hole. This is
	 *          basically the only required method to add this exemption, don't
	 *          add it to any other method if you don't exactly know what it does
	 *
	 * @NoAdminRequired
	 * @NoCSRFRequired
	 */
	public function index() {
		$uploadLimit = Util::uploadLimit();
		$params = [
			'user' => $this->userId,
			'uploadLimit' => $uploadLimit
		];

		/** @var ContentSecurityPolicy $csp */
		$csp = new ContentSecurityPolicy();
		$csp->addAllowedConnectDomain('*');

		/** @var TemplateResponse $response */
		$response = new TemplateResponse('pkdrive', 'main', $params);  // templates/main.php
		$response->setContentSecurityPolicy($csp);

		return $response;
	}

	/**
	 * Simply method that posts back the payload of the request
	 * @NoAdminRequired
	 */
	public function doEcho($echo) {
		return new DataResponse(['echo' => $echo]);
	}


}