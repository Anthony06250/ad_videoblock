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

use AdVideoBlock\Install\InstallerFactory;

if (!defined('_PS_VERSION_')) {
    exit;
}

require_once __DIR__ . '/vendor/autoload.php';

class Ad_VideoBlock extends Module
{

    public function __construct()
    {
        $this->name = 'ad_videoblock';
        $this->author = 'Anthony DURET';
        $this->version = '1.0.0';
        $this->tab = 'front_office_features';
        $this->ps_versions_compliancy = ['min' => '1.7.7.0', 'max' => _PS_VERSION_];
        $this->bootstrap = true;

        $tabNames = [];
        foreach (Language::getLanguages() as $lang) {
            $tabNames[$lang['locale']] = $this->trans('Video Block', [], 'Modules.Advideoblock.Admin', $lang['locale']);
        }
        $this->tabs = [
            [
                'route_name' => 'admin_ad_videoblock_index',
                'class_name' => 'AdminVideoBlock',
                'visible' => true,
                'name' => $tabNames,
                'parent_class_name' => 'AdminParentThemes',
                'wording' => 'Video Block',
                'wording_domain' => 'Modules.Advideoblock.Admin'
            ],
        ];

        parent::__construct();

        $this->displayName = $this->trans('AD - Video Block', [], 'Modules.Advideoblock.Admin');
        $this->description = $this->trans('Display a video block on the homepage and on the categories.', [],
            'Modules.Advideoblock.Admin');

        $this->confirmUninstall = $this->trans('Are you sure you want to uninstall ?', [],
            'Modules.Advideoblock.Admin');
    }

    /**
     * @return bool
     * @throws PrestaShopDatabaseException
     * @throws PrestaShopException
     */
    public function install(): bool
    {
        if (Shop::isFeatureActive()) {
            Shop::setContext(Shop::CONTEXT_ALL);
        }

        $installer = InstallerFactory::create();

        return parent::install()
            && $installer->install($this);
    }

    /**
     * @return bool
     */
    public function uninstall(): bool
    {
        $installer = InstallerFactory::create();

        return parent::uninstall()
            && $installer->uninstall();
    }

    /**
     * @return void
     */
    public function hookActionFrontControllerSetMedia(): void
    {
        $this->context->controller->registerStylesheet(
            'module-' . $this->name . '-default',
            'modules/' . '/' . $this->name . '/views/css/default.css',
            ['media' => 'all', 'priority' => 200]
        );
        $this->context->controller->registerStylesheet(
            'module-' . $this->name . '-custom',
            'modules/' . '/' . $this->name . '/views/css/custom.css',
            ['media' => 'all', 'priority' => 200]
        );
    }

    public function hookDisplayAdminOrderTop(array $params)
    {
        return $this->render(_PS_MODULE_DIR_ . '/' . $this->name . '/views/templates/widget/videoblock.tpl', [
            'videoblocks' => []
        ]);
    }

    public function hookDisplayHome(array $params)
    {
//        return $this->render(_PS_MODULE_DIR_ . '/' . $this->name . '/views/templates/widget/videoblock.tpl', [
//            'videoblocks' => []
//        ]);
    }

    private function render(string $template, array $params = []): string
    {
        $twig = $this->get('twig');

        return $twig->render($template, $params);
    }

    /**
     * @return bool
     */
    public function isUsingNewTranslationSystem(): bool
    {
        return true;
    }
}
