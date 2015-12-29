<?php
namespace OCA\PkDrive\AppInfo;

use OCA\PkDrive\Hooks\ScanHooks;
use OCP\AppFramework\App;
use OCP\AppFramework\IAppContainer;

class Application extends App
{
    public function __construct(array $urlParams=array()){
        parent::__construct('pkdrive', $urlParams);

        $container = $this->getContainer();
    }
}