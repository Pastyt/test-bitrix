<?php

use Bitrix\Main\Application;
use Bitrix\Main\DB\Connection;
use Bitrix\Main\ModuleManager;

class currency_main extends CModule
{
    /**
     * @var string
     */
    public $MODULE_ID = 'currency.main';

    /**
     * @var string
     */
    public $MODULE_VERSION;

    /**
     * @var string
     */
    public $MODULE_VERSION_DATE;

    /**
     * @var string
     */
    public $MODULE_NAME;

    /**
     * @var string
     */
    public $MODULE_DESCRIPTION;

    /**
     * @var string
     */
    public $PARTNER_NAME;

    /**
     * @var string
     */
    public $PARTNER_URI;

    /**
     * @var string
     */
    public string $MODULE_PATH;

    /**
     * @var Connection
     * @var
     */
    public Connection $CONNECTION;
    
    /**
     *
     */
    public function __construct()
    {
        $this->MODULE_NAME = 'Валюты';
        $this->MODULE_DESCRIPTION = 'Смотреть валюты';
        $this->PARTNER_NAME = 'Валюты';
        $this->PARTNER_URI = 'Валюты';
        $this->MODULE_PATH = $this->getModulePath();
        $this->CONNECTION = Application::getConnection();

        $arModuleVersion = [];
        include $this->MODULE_PATH . '/install/version.php';

        $this->MODULE_VERSION = $arModuleVersion['VERSION'];
        $this->MODULE_VERSION_DATE = $arModuleVersion['VERSION_DATE'];
    }

    /**
     * return module path
     *
     * @return string
     */
    public function getModulePath(): string
    {
        $modulePath = explode('/', __FILE__);
        $modulePath = array_slice($modulePath, 0, array_search($this->MODULE_ID, $modulePath) + 1);

        return implode('/', $modulePath);
    }

    /**
     * Install module
     *
     * @return void
     */
    public function doInstall(): void
    {
        global $APPLICATION;


        ModuleManager::registerModule($this->MODULE_ID);

//        $this->installDB();
//        $this->installFiles();
//        $this->installEvents();

        $APPLICATION->IncludeAdminFile(
            'Установка завершена',
            $_SERVER['DOCUMENT_ROOT'] . "/local/modules/" . $this->MODULE_ID . "/install/step.php"
        );
    }

    /**
     * Remove module
     *
     * @return void
     */
    public function doUninstall(): void
    {
        global $APPLICATION;

//        $this->UnInstallFiles();
//        $this->UnInstallEvents();
//        $this->UnInstallDB();
        ModuleManager::unRegisterModule($this->MODULE_ID);

        $APPLICATION->IncludeAdminFile(
            GetMessage('BPG_UNINSTALL_TITLE'),
            $_SERVER['DOCUMENT_ROOT'] . '/local/modules/' . $this->MODULE_ID . '/install/unstep.php'
        );
    }

    /**
     * Add tables to the database
     *
     * @return bool
     */
    public function installDB(): bool
    {
    }

    /**
     * Remove tables from the database
     *
     * @return bool
     */
    public function unInstallDB(): bool
    {
    }

    /**
     * Copy files module
     *
     * @return bool
     */
    public function installFiles(): bool
    {
        CopyDirFiles($this->MODULE_PATH . '/install/admin', getenv('DOCUMENT_ROOT') . '/bitrix/admin', true, true);
        return true;
    }

    /**
     * Remove files module
     *
     * @return bool
     */
    public function unInstallFiles(): bool
    {
        DeleteDirFiles($this->MODULE_PATH . '/install/admin', getenv('DOCUMENT_ROOT') . '/bitrix/admin');
        return true;
    }
}
