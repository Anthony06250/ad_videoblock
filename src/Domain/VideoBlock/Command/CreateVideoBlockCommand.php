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

class CreateVideoBlockCommand extends AbstractVideoBlockCommand
{
    /**
     * @var int
     */
    private $id_category;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $subtitle;

    /**
     * @var string
     */
    private $url;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $options;

    /**
     * @var bool
     */
    private $fullscreen;

    /**
     * @var bool
     */
    private $active;

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
     * @param array $data
     * @return CreateVideoBlockCommand
     */
    public function fromArray(array $data): CreateVideoBlockCommand
    {
        foreach ($data as $key => $value) {
            if (empty($this->{$key})) {
                $this->{$key} = $value;
            }
        }

        return $this;
    }
}
