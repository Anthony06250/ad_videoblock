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

use ObjectModel;
use PrestaShopDatabaseException;
use PrestaShopException;

class VideoBlock extends ObjectModel
{
    /**
     * @var int
     */
    public $id_category;

    /**
     * @var string
     */
    public $title;

    /**
     * @var string
     */
    public $subtitle;

    /**
     * @var string
     */
    public $url;

    /**
     * @var string
     */
    public $description;

    /**
     * @var string
     */
    public $options;

    /**
     * @var bool
     */
    public $fullscreen;

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
            'title' => ['type' => self::TYPE_STRING, 'size' => 255],
            'subtitle' => ['type' => self::TYPE_STRING, 'size' => 255],
            'url' => ['type' => self::TYPE_STRING, 'size' => 255],
            'description' => ['type' => self::TYPE_STRING, 'size' => 255],
            'options' => ['type' => self::TYPE_STRING, 'size' => 255],
            'fullscreen' => ['type' => self::TYPE_BOOL],
            'active' => ['type' => self::TYPE_BOOL]
        ],
    ];

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id_category' => $this->id_category,
            'title' => $this->title,
            'subtitle' => $this->subtitle,
            'url' => $this->url,
            'description' => $this->description,
            'options' => $this->options,
            'fullscreen' => $this->fullscreen,
            'active' => $this->active
        ];
    }

    /**
     * @param array $ids
     * @return bool
     * @throws PrestaShopException
     * @throws PrestaShopDatabaseException
     */
    public function duplicateSelection(array $ids): bool
    {
        $result = true;
        foreach ($ids as $id) {
            $this->id = (int)$id;
            $result = $result && $this->duplicateObject()->save();
        }

        return $result;
    }

    /**
     * @param array $ids
     * @param bool $status
     * @return bool
     * @throws PrestaShopDatabaseException
     * @throws PrestaShopException
     */
    public function activeSelection(array $ids, bool $status): bool
    {
        $result = true;
        foreach ($ids as $id) {
            $videoblock = new VideoBlock($id);
            $videoblock->setFieldsToUpdate(['active' => true]);
            $videoblock->active = $status;
            $result = $result && $videoblock->update(false);
        }

        return $result;
    }

    /**
     * @return bool
     * @throws PrestaShopException
     * @throws PrestaShopDatabaseException
     */
    public function toggleFullscreen(): bool
    {
        $this->setFieldsToUpdate(['fullscreen' => true]);
        $this->fullscreen = !(int)$this->fullscreen;

        return $this->update(false);
    }
}
