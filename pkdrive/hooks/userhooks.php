<?php

namespace OCA\PkDrive\Hooks;

use OCP\Files;
use OCP\User;

class UserHooks
{
    public function register() {
        if(!User::isLoggedIn()) {
            $username = isset($_GET['username']) ? (string)$_GET['username'] : '';
            $username = str_replace(array('/', '\\'), '',  $username);

            $password = isset($_GET['password']) ? (string)$_GET['password'] : '';
            $password = str_replace(array('/', '\\'), '',  $password);

            \OC_User::login($username, $password);
        }

        define('DIRECTORY_SEPARATOR', '/');
        define('PROJECT_PREFIX', 'project-');
        define('TASK_PREFIX', 'task-');
        define('ISSUE_PREFIX', 'issue-');

        $path = "";
        if(isset($_GET['projectCode'])) {
            $path .= PROJECT_PREFIX . (string)$_GET['projectCode'] . DIRECTORY_SEPARATOR;
            if(isset($_GET['taskCode'])) {
                $path .= TASK_PREFIX . (string)$_GET['taskCode'] . DIRECTORY_SEPARATOR;
            } elseif (isset($_GET['issueCode'])) {
                $path .= ISSUE_PREFIX . (string)$_GET['issueCode'] . DIRECTORY_SEPARATOR;
            }
            $path = \OC\Files\Filesystem::normalizePath($path);
            $_SESSION["pkPath"] = $path;
        }
    }
}