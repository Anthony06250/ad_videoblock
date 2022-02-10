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

namespace AdVideoBlock\Grid\Factory;

use AdVideoBlock\Grid\Action\DeleteBulkAction;
use PrestaShop\PrestaShop\Core\Grid\Action\Bulk\BulkActionCollection;
use PrestaShop\PrestaShop\Core\Grid\Action\Row\RowActionCollection;
use PrestaShop\PrestaShop\Core\Grid\Action\Row\Type\LinkRowAction;
use PrestaShop\PrestaShop\Core\Grid\Action\Row\Type\SubmitRowAction;
use PrestaShop\PrestaShop\Core\Grid\Column\ColumnCollection;
use PrestaShop\PrestaShop\Core\Grid\Column\ColumnCollectionInterface;
use PrestaShop\PrestaShop\Core\Grid\Column\Type\Common\ActionColumn;
use PrestaShop\PrestaShop\Core\Grid\Column\Type\Common\BulkActionColumn;
use PrestaShop\PrestaShop\Core\Grid\Column\Type\Common\ImageColumn;
use PrestaShop\PrestaShop\Core\Grid\Column\Type\Common\ToggleColumn;
use PrestaShop\PrestaShop\Core\Grid\Column\Type\DataColumn;
use PrestaShop\PrestaShop\Core\Grid\Definition\Factory\AbstractGridDefinitionFactory;
use PrestaShop\PrestaShop\Core\Grid\Filter\Filter;
use PrestaShop\PrestaShop\Core\Grid\Filter\FilterCollection;
use PrestaShop\PrestaShop\Core\Grid\Filter\FilterCollectionInterface;
use PrestaShopBundle\Form\Admin\Type\SearchAndResetType;
use PrestaShopBundle\Form\Admin\Type\YesAndNoChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class VideoBlockGridDefinitionFactory extends AbstractGridDefinitionFactory
{
    const GRID_ID = 'videoblock';

    /**
     * @return string
     */
    protected function getId(): string
    {
        return self::GRID_ID;
    }

    /**
     * @return string
     */
    protected function getName(): string
    {
        return $this->trans('List of Video Block', [], 'Modules.Advideoblock.Admin');
    }

    /**
     * @return ColumnCollection|ColumnCollectionInterface
     */
    protected function getColumns()
    {
        return (new ColumnCollection())
            ->add((new BulkActionColumn('bulk_action'))
                ->setName('')
                ->setOptions([
                    'bulk_field' => 'id_ad_videoblock',
                ])
            )
            ->add((new ImageColumn('video_path'))
                ->setName($this->trans('Video', [], 'Modules.Advideoblock.Admin'))
                ->setOptions([
                    'src_field' => 'video_path',
                ])
            )
            ->add((new DataColumn('block_title'))
                ->setName($this->trans('Title', [], 'Modules.Advideoblock.Admin'))
                ->setOptions([
                    'field' => 'block_title',
                ])
            )
            ->add((new DataColumn('block_subtitle'))
                ->setName($this->trans('Subtitle', [], 'Modules.Advideoblock.Admin'))
                ->setOptions([
                    'field' => 'block_subtitle',
                ])
            )
            ->add((new DataColumn('video_title'))
                ->setName($this->trans('Description', [], 'Modules.Advideoblock.Admin'))
                ->setOptions([
                    'field' => 'video_title',
                ])
            )
            ->add((new DataColumn('id_category'))
                ->setName($this->trans('Category', [], 'Modules.Advideoblock.Admin'))
                ->setOptions([
                    'field' => 'id_category',
                ])
            )
            ->add((new ToggleColumn('video_fullscreen'))
                    ->setName($this->trans('Fullscreen', [], 'Modules.Advideoblock.Admin'))
                    ->setOptions([
                        'field' => 'video_fullscreen',
                        'primary_field' => 'id_ad_videoblock',
                        'route' => 'admin_ad_videoblock_toggle_fullscreen',
                        'route_param_name' => 'id',
                    ])
            )
            ->add((new ToggleColumn('active'))
                    ->setName($this->trans('Active', [], 'Modules.Advideoblock.Admin'))
                    ->setOptions([
                        'field' => 'active',
                        'primary_field' => 'id_ad_videoblock',
                        'route' => 'admin_ad_videoblock_toggle_status',
                        'route_param_name' => 'id',
                    ])
            )
            ->add((new ActionColumn('actions'))
                    ->setName($this->trans('Actions', [], 'Admin.Global'))
                    ->setOptions([
                        'actions' => (new RowActionCollection())
                            ->add((new LinkRowAction('edit'))
                                    ->setName('Edit')
                                    ->setIcon('edit')
                                    ->setOptions([
                                        'route' => 'admin_ad_videoblock_edit',
                                        'route_param_name' => 'id',
                                        'route_param_field' => 'id_ad_videoblock',
                                        'clickable_row' => true,
                                    ])
                            )
                            ->add((new SubmitRowAction('delete'))
                                    ->setName('Delete')
                                    ->setIcon('delete')
                                    ->setOptions([
                                        'confirm_message' => $this->trans('Delete selected item ?', [], 'Modules.Advideoblock.Admin'),
                                        'route' => 'admin_ad_videoblock_delete',
                                        'route_param_name' => 'id',
                                        'route_param_field' => 'id_ad_videoblock',
                                    ])
                            )
                    ])
            );
    }

    /**
     * @return FilterCollection|FilterCollectionInterface
     */
    protected function getFilters()
    {
        return (new FilterCollection())
            ->add((new Filter('block_title', TextType::class))
                ->setTypeOptions([
                        'required' => false,
                        'attr' => [
                            'placeholder' => $this->trans('Title', [], 'Modules.Advideoblock.Admin'),
                        ],
                    ])
                ->setAssociatedColumn('block_title')
            )
            ->add((new Filter('block_subtitle', TextType::class))
                ->setTypeOptions([
                    'required' => false,
                    'attr' => [
                        'placeholder' => $this->trans('Subtitle', [], 'Modules.Advideoblock.Admin'),
                    ],
                ])
                ->setAssociatedColumn('block_subtitle')
            )
            ->add((new Filter('video_title', TextType::class))
                ->setTypeOptions([
                        'required' => false,
                        'attr' => [
                            'placeholder' => $this->trans('Description', [], 'Modules.Advideoblock.Admin'),
                        ],
                    ])
                ->setAssociatedColumn('video_title')
            )
            ->add((new Filter('id_category', TextType::class))
                ->setTypeOptions([
                    'required' => false,
                    'attr' => [
                        'placeholder' => $this->trans('Category', [], 'Modules.Advideoblock.Admin'),
                    ],
                ])
                ->setAssociatedColumn('id_category')
            )
            ->add((new Filter('video_fullscreen', YesAndNoChoiceType::class))
                    ->setAssociatedColumn('video_fullscreen')
            )
            ->add((new Filter('active', YesAndNoChoiceType::class))
                    ->setAssociatedColumn('active')
            )
            ->add((new Filter('actions', SearchAndResetType::class))
                    ->setTypeOptions([
                        'reset_route' => 'admin_common_reset_search_by_filter_id',
                        'reset_route_params' => [
                            'filterId' => self::GRID_ID,
                        ],
                        'redirect_route' => 'admin_ad_videoblock_index',
                    ])
                    ->setAssociatedColumn('actions')
            );
    }

    protected function getBulkActions()
    {
        return (new BulkActionCollection())
            ->add((new DeleteBulkAction('delete_selection'))
                ->setName('Delete selection')
                ->setOptions([
                    'bulk_delete_route' => 'admin_ad_videoblock_delete_bulk',
                ])
            );
    }
}
