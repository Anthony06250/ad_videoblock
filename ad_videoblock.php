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

use AdVideoBlock\Domain\VideoBlock\Query\GetVideoBlockForHook;
use AdVideoBlock\Install\Installer;
use AdVideoBlock\Install\InstallerFactory;
use PrestaShop\PrestaShop\Core\Module\WidgetInterface;

if (!defined('_PS_VERSION_')) {
    exit;
}

require_once __DIR__ . '/vendor/autoload.php';

class Ad_VideoBlock extends Module implements WidgetInterface
{
    /**
     * -> TODO: Made multiple language
     * -> TODO: Made multiple shop
     */

    /**
     * Kernel for get services from hooks
     * @var AppKernel
     */
    private $hookKernel;

    public function __construct()
    {
        $this->name = 'ad_videoblock';
        $this->author = 'Anthony DURET';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->ps_versions_compliancy = ['min' => '1.7.7.0', 'max' => _PS_VERSION_];
        $this->bootstrap = true;

        $this->tabs = Installer::getTabs();

        parent::__construct();

        $this->displayName = $this->trans('AD - Video Block', [], 'Modules.Advideoblock.Admin');
        $this->description = $this->trans('Display a video block on the homepage and on the categories.', [], 'Modules.Advideoblock.Admin');

        $this->confirmUninstall = $this->trans('Are you sure you want to uninstall ?', [], 'Modules.Advideoblock.Admin');
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

        $installer = InstallerFactory::create($this);

        return parent::install()
            && $installer->install();
    }

    /**
     * @return bool
     */
    public function uninstall(): bool
    {
        $installer = InstallerFactory::create($this);

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

    /**
     * @param mixed $hookName
     * @param array $configuration
     * @return false|string|void
     * @throws Exception
     */
    public function renderWidget($hookName, array $configuration)
    {
        if ($hookName == 'displayHome'
            || Tools::getValue('id_category')) {
                return $this->render('@Modules/ad_videoblock/views/templates/widget/videoblock.html.twig', [
                    'videoblocks' => $this->getWidgetVariables($hookName, $configuration)
                ]);
        }
    }

    /**
     * @param mixed $hookName
     * @param array $configuration
     * @return array|null
     * @throws Exception
     */
    public function getWidgetVariables($hookName, array $configuration): ?array
    {
        $category = $hookName == 'displayHome' ? 2 : (int)Tools::getValue('id_category');
        $response = $this->handle(new GetVideoBlockForHook($category));

        return $response->getData();
    }

    /**
     * @param string $template
     * @param array $params
     * @return mixed
     */
    private function render(string $template, array $params)
    {
        $this->loadHookKernel();

        return $this->hookKernel->getContainer()->get('twig')->render($template, $params);
    }

    /**
     * @param mixed $query
     * @return mixed
     */
    private function handle($query)
    {
        $this->loadHookKernel();

        return $this->hookKernel->getContainer()->get('prestashop.core.query_bus')->handle($query);
    }

    /**
     * @return void
     */
    private function loadHookKernel(): void
    {
        // Load kernel for get services from hooks
        if (!$this->hookKernel) {
            $this->hookKernel = new AppKernel(_PS_MODE_DEV_ ? 'dev' : 'prod', _PS_MODE_DEV_);

            $this->hookKernel->boot();
        }
    }

    /**
     * @return bool
     */
    public function isUsingNewTranslationSystem(): bool
    {
        return true;
    }
}
