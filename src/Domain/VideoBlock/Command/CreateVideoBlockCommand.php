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

namespace AdVideoBlock\Domain\VideoBlock\Command;

class CreateVideoBlockCommand
{
    /**
     * @var int
     */
    private $id_category;

    /**
     * @var string
     */
    private $block_title;

    /**
     * @var string
     */
    private $block_subtitle;

    /**
     * @var string
     */
    private $video_path;

    /**
     * @var string
     */
    private $video_title;

    /**
     * @var string
     */
    private $video_options;

    /**
     * @var int
     */
    private $video_fullscreen;

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
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
     * @return CreateVideoBlockCommand
     */
    public function fromArray(array $data): CreateVideoBlockCommand
    {
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