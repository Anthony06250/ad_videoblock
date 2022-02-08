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

class VideoBlock extends \ObjectModel
{
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
     * @var int
     */
    public $video_fullscreen;

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
            'video_fullscreen' => ['type' => self::TYPE_INT, 'validate' => 'isUnsignedInt', 'required' => true],
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
            'video_fullscreen' => $this->video_fullscreen
        ];
    }

    /**
     * @param array $data
     * @return VideoBlock
     */
    public function fromArray(array $data): VideoBlock
    {
        $this->id_ad_videoblock = $data['id_ad_videoblock'] ?? null;
        $this->id_category = $data['id_category'];
        $this->block_title = $data['block_title'];
        $this->block_subtitle = $data['block_subtitle'];
        $this->video_path = $data['video_path'];
        $this->video_title = $data['video_title'];
        $this->video_options = $data['video_options'];
        $this->video_fullscreen = $data['video_fullscreen'];

        return $this;
    }
}