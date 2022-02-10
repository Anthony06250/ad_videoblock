<?php
/*
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License version 3.0
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License version 3.0
 */

declare(strict_types=1);

namespace AdVideoBlock\Install;

use Db;
use Module;
use PrestaShopDatabaseException;

class Installer
{
    /**
     * @var FixturesInstaller
     */
    private $fixtures_installer;

    /**
     * @param FixturesInstaller $fixtures_installer
     */
    public function __construct(FixturesInstaller $fixtures_installer)
    {
        $this->fixtures_installer = $fixtures_installer;
    }

    /**
     * @param Module $module
     * @return bool
     * @throws PrestaShopDatabaseException
     */
    public function install(Module $module): bool
    {
        if (!$this->registerHooks($module)
            || !$this->installDatabase()) {
            return false;
        }

        $this->fixtures_installer->install();

        return true;
    }

    /**
     * @return bool
     */
    public function uninstall(): bool
    {
        return $this->uninstallDatabase();
    }

    /**
     * @param Module $module
     * @return bool
     */
    private function registerHooks(Module $module): bool
    {
        $hooks = [
            'displayAdminOrderTop',
            'displayHome'
        ];

        return $module->registerHook($hooks);
    }

    /**
     * @return bool
     */
    private function installDatabase(): bool
    {
        $queries = [
            'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'ad_videoblock` (
               `id_ad_videoblock` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
               `id_category` int(10) UNSIGNED NOT NULL,
               `block_title` varchar(255) DEFAULT NULL,
               `block_subtitle` varchar(255) DEFAULT NULL,
               `video_path` varchar(255) NOT NULL,
               `video_title` varchar(255) DEFAULT NULL,
               `video_options` varchar(255) DEFAULT NULL,
               `video_fullscreen` int(2) UNSIGNED NOT NULL,
               `active` int(2) UNSIGNED NOT NULL,
               PRIMARY KEY  (`id_ad_videoblock`)
            ) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8;'
        ];

        return $this->executeQueries($queries);
    }

    /**
     * @return bool
     */
    private function uninstallDatabase(): bool
    {
        $queries = [
            'DROP TABLE IF EXISTS `' . _DB_PREFIX_ . 'ad_videoblock`',
        ];

        return $this->executeQueries($queries);
    }

    /**
     * @param array $queries
     * @return bool
     */
    private function executeQueries(array $queries): bool
    {
        foreach ($queries as $query) {
            if (!Db::getInstance()->execute($query)) {
                return false;
            }
        }

        return true;
    }
}
