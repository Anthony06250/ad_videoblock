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

namespace AdVideoBlock\Form;

use PrestaShopBundle\Form\Admin\Type\SwitchType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class VideoBlockType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('id_ad_videoblock', HiddenType::class)
            ->add('id_category', NumberType::class, [
                "attr" => [
                    "label" => "Category ID",
                    "placeholder" => "The category id"
                ]
            ])
            ->add('block_title', TextType::class, [
                "attr" => [
                    "label" => "Block title",
                    "placeholder" => "The block title"
                ]
            ])
            ->add('block_subtitle', TextType::class, [
                "attr" => [
                    "label" => "Block subtitle",
                    "placeholder" => "The block subtitle"
                ]
            ])
            ->add('video_path', TextType::class, [
                "attr" => [
                    "label" => "Video path",
                    "placeholder" => "The video path"
                ]
            ])
            ->add('video_title', TextType::class, [
                "attr" => [
                    "label" => "Video title",
                    "placeholder" => "The video title"
                ]
            ])
            ->add('video_options', TextType::class, [
                "attr" => [
                    "label" => "Video options",
                    "placeholder" => "The video options"
                ]
            ])
            ->add('video_fullscreen', SwitchType::class, [
                'choices' => [
                    'OFF' => false,
                    'ON' => true
                ],
            ]);
    }
}
