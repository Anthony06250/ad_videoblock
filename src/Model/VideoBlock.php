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

namespace AdVideoBlock\Model;

use Db;
use ObjectModel;
use PrestaShopException;
use Tools;
use Validate;

class VideoBlock extends ObjectModel
{
    /**
     * -> TODO: See for delete $id_ad_videoblock and use instead $this->id inherit by parent
     */

    /**
     * @var int
     */
    public $id_ad_videoblock;

    /**
     * @var int
     */
    public $id_category;

    /**
     * @var string
     */
    public $block_title;

    /**
     * @var string
     */
    public $block_subtitle;

    /**
     * @var string
     */
    public $video_path;

    /**
     * @var string
     */
    public $video_title;

    /**
     * @var string
     */
    public $video_options;

    /**
     * @var bool
     */
    public $video_fullscreen;

    /**
     * @var bool
     */
    public $active;

    /**
     * @see ObjectModel::$definition
     */
    public static $definition = [
        'table' => 'ad_videoblock',
        'primary' => 'id_ad_videoblock',
        'fields' => [
            'id_category' => ['type' => self::TYPE_INT, 'validate' => 'isUnsignedInt', 'required' => true],
            'block_title' => ['type' => self::TYPE_STRING, 'size' => 255],
            'block_subtitle' => ['type' => self::TYPE_STRING, 'size' => 255],
            'video_path' => ['type' => self::TYPE_STRING, 'size' => 255],
            'video_title' => ['type' => self::TYPE_STRING, 'size' => 255],
            'video_options' => ['type' => self::TYPE_STRING, 'size' => 255],
            'video_fullscreen' => ['type' => self::TYPE_BOOL],
            'active' => ['type' => self::TYPE_BOOL]
        ],
    ];

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id_ad_videoblock' => $this->id_ad_videoblock,
            'id_category' => $this->id_category,
            'block_title' => $this->block_title,
            'block_subtitle' => $this->block_subtitle,
            'video_path' => $this->video_path,
            'video_title' => $this->video_title,
            'video_options' => $this->video_options,
            'video_fullscreen' => $this->video_fullscreen,
            'active' => $this->active
        ];
    }

    /**
     * @return bool|void
     * @throws PrestaShopException
     */
    public function toggleFullscreen()
    {
        if (!Validate::isTableOrIdentifier(VideoBlock::$definition['primary']) OR !Validate::isTableOrIdentifier(VideoBlock::$definition['table'])) {
            die(Tools::displayError());
        } else if (!key_exists('video_fullscreen', (array)$this)) {
            die(Tools::displayError());
        }

        return Db::getInstance()->Execute('
		    UPDATE `'.pSQL(_DB_PREFIX_.$this->table).'`
		    SET `video_fullscreen` = !`video_fullscreen`
		    WHERE `'.pSQL(VideoBlock::$definition['primary']).'` = ' . intval($this->id));
    }
}
