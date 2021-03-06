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

namespace OCA\PkDrive\AppInfo;

use OCP\AppFramework\App;

$app = new App('pkdrive');
$container = $app->getContainer();

$container->query('OCP\INavigationManager')->add(function () use ($container) {
	$urlGenerator = $container->query('OCP\IURLGenerator');
	$l10n = $container->query('OCP\IL10N');
	return [
		// the string under which your app will be referenced in owncloud
		'id' => 'pkdrive',

		// sorting weight for the navigation. The higher the number, the higher
		// will it be listed in the navigation
		'order' => 10,

		// the route that will be shown on startup
		'href' => $urlGenerator->linkToRoute('pkdrive.page.index'),

		// the icon that will be shown in the navigation
		// this file needs to exist in img/
		'icon' => $urlGenerator->imagePath('pkdrive', 'app.svg'),

		// the title of your application. This will be used in the
		// navigation or on the settings page of your app
		'name' => $l10n->t('Pk Drive'),
	];
});

$container->query('OCA\PkDrive\Hooks\UserHooks')->register();