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
    }
}