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

use PrestaShopBundle\Form\Admin\Type\CategoryChoiceTreeType;
use PrestaShopBundle\Form\Admin\Type\SwitchType;
use PrestaShopBundle\Form\Admin\Type\TranslatorAwareType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Url;

final class VideoBlockType extends TranslatorAwareType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('id_ad_videoblock', HiddenType::class)
            ->add('id_category', CategoryChoiceTreeType::class, [
                'required' => true,
                'label' => $this->trans('Category', 'Modules.Advideoblock.Admin'),
                'disabled_values' => [0]
            ])
            ->add('title', TextType::class, [
                'required' => false,
                'constraints' => [
                    new Length(['max' => 255])
                ],
                'attr' => [
                    'label' => $this->trans('Block title', 'Modules.Advideoblock.Admin'),
                    'placeholder' => $this->trans('The block title', 'Modules.Advideoblock.Admin')
                ]
            ])
            ->add('subtitle', TextType::class, [
                'required' => false,
                'constraints' => [
                    new Length(['max' => 255])
                ],
                'attr' => [
                    'label' => $this->trans('Block subtitle', 'Modules.Advideoblock.Admin'),
                    'placeholder' => $this->trans('The block subtitle', 'Modules.Advideoblock.Admin')
                ]
            ])
            ->add('url', TextType::class, [
                'constraints' => [
                    new Length(['max' => 255]),
                    new Url()
                ],
                'attr' => [
                    'label' => $this->trans('Video url', 'Modules.Advideoblock.Admin'),
                    'placeholder' => $this->trans('The video url', 'Modules.Advideoblock.Admin')
                ]
            ])
            ->add('description', TextType::class, [
                'required' => false,
                'constraints' => [
                    new Length(['max' => 255])
                ],
                'attr' => [
                    'label' => $this->trans('Video description', 'Modules.Advideoblock.Admin'),
                    'placeholder' => $this->trans('The video description', 'Modules.Advideoblock.Admin')
                ]
            ])
            ->add('options', TextType::class, [
                'required' => false,
                'constraints' => [
                    new Length(['max' => 255])
                ],
                'attr' => [
                    'label' => $this->trans('Video options', 'Modules.Advideoblock.Admin'),
                    'placeholder' => $this->trans('The video options', 'Modules.Advideoblock.Admin')
                ]
            ])
            ->add('fullscreen', SwitchType::class, [
                'label' => $this->trans('Video fullscreen', 'Modules.Advideoblock.Admin'),
                'choices' => [
                    'OFF' => false,
                    'ON' => true
                ],
            ])
            ->add('active', SwitchType::class, [
                'label' => $this->trans('Video active', 'Modules.Advideoblock.Admin'),
                'choices' => [
                    'OFF' => false,
                    'ON' => true
                ],
            ]);
    }
}
