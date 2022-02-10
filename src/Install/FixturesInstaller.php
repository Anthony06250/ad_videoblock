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
use PrestaShopBundle\Install\Database;
use PrestaShopDatabaseException;

class FixturesInstaller
{
    /**
     * @var Database
     */
    private $database;

    /**
     * @param Db $database
     */
    public function __construct(Db $database)
    {
        $this->database = $database;
    }

    /**
     * @return void
     * @throws PrestaShopDatabaseException
     */
    public function install(): void
    {
        $datas = [
            [
                'id_category' => 0,
                'block_title' => 'Custom video block',
                'block_subtitle' => 'Lorem ipsum dolor sit amet conse ctetu',
                'video_path' => 'https://www.youtube.com/embed/XgGR0fneOhA',
                'video_title' => 'Fairphone 4, la nouvelle version du smartphone éthique',
                'video_options' => 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture',
                'video_fullscreen' => 1,
                'active' => 1
            ]
        ];

        foreach ($datas as $data) {
            $this->database->insert('ad_videoblock', $data);
        }
    }
}
