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

use AdVideoBlock\Model\VideoBlock;
use PrestaShopDatabaseException;
use PrestaShopException;

final class FixturesInstaller
{
    /**
     * @return void
     * @throws PrestaShopDatabaseException
     * @throws PrestaShopException
     */
    public function install(): void
    {
        $datas = [
            [
                'id_category' => 2,
                'title' => 'Custom video block',
                'subtitle' => 'Lorem ipsum dolor sit amet conse ctetu',
                'url' => 'XgGR0fneOhA',
                'description' => 'Fairphone 4, la nouvelle version du smartphone éthique',
                'options' => 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture',
                'fullscreen' => 1,
                'active' => 1
            ]
        ];

        foreach ($datas as $data) {
            (new VideoBlock())->fromArray($data)->save();
        }
    }
}
