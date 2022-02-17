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
use AdVideoBlock\Grid\Action\DisableBulkAction;
use AdVideoBlock\Grid\Action\DividerBulkAction;
use AdVideoBlock\Grid\Action\DuplicateBulkAction;
use AdVideoBlock\Grid\Action\EnableBulkAction;
use PrestaShop\PrestaShop\Core\Grid\Action\Bulk\BulkActionCollection;
use PrestaShop\PrestaShop\Core\Grid\Action\Bulk\BulkActionCollectionInterface;
use PrestaShop\PrestaShop\Core\Grid\Action\ModalOptions;
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
use PrestaShop\PrestaShop\Core\Grid\Definition\Factory\AbstractFilterableGridDefinitionFactory;
use PrestaShop\PrestaShop\Core\Grid\Filter\Filter;
use PrestaShop\PrestaShop\Core\Grid\Filter\FilterCollection;
use PrestaShop\PrestaShop\Core\Grid\Filter\FilterCollectionInterface;
use PrestaShopBundle\Form\Admin\Type\SearchAndResetType;
use PrestaShopBundle\Form\Admin\Type\YesAndNoChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

final class VideoBlockGridDefinitionFactory extends AbstractFilterableGridDefinitionFactory
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
                ->setOptions(['bulk_field' => 'id'])
            )
            ->add((new DataColumn('id'))
                ->setName($this->trans('ID', [], 'Modules.Advideoblock.Admin'))
                ->setOptions(['field' => 'id'])
            )
            ->add((new ImageColumn('url'))
                ->setName($this->trans('Video', [], 'Modules.Advideoblock.Admin'))
                ->setOptions(['src_field' => 'url'])
            )
            ->add((new DataColumn('title'))
                ->setName($this->trans('Title', [], 'Modules.Advideoblock.Admin'))
                ->setOptions(['field' => 'title'])
            )
            ->add((new DataColumn('subtitle'))
                ->setName($this->trans('Subtitle', [], 'Modules.Advideoblock.Admin'))
                ->setOptions(['field' => 'subtitle'])
            )
            ->add((new DataColumn('description'))
                ->setName($this->trans('Description', [], 'Modules.Advideoblock.Admin'))
                ->setOptions(['field' => 'description'])
            )
            ->add((new DataColumn('category'))
                ->setName($this->trans('Category', [], 'Modules.Advideoblock.Admin'))
                ->setOptions(['field' => 'category'])
            )
            ->add((new ToggleColumn('fullscreen'))
                    ->setName($this->trans('Fullscreen', [], 'Modules.Advideoblock.Admin'))
                    ->setOptions([
                        'field' => 'fullscreen',
                        'primary_field' => 'id',
                        'route' => 'admin_ad_videoblock_toggle_fullscreen',
                        'route_param_name' => 'id'
                    ])
            )
            ->add((new ToggleColumn('active'))
                    ->setName($this->trans('Active', [], 'Modules.Advideoblock.Admin'))
                    ->setOptions([
                        'field' => 'active',
                        'primary_field' => 'id',
                        'route' => 'admin_ad_videoblock_toggle_active',
                        'route_param_name' => 'id'
                    ])
            )
            ->add((new ActionColumn('actions'))
                    ->setName($this->trans('Actions', [], 'Modules.Advideoblock.Admin'))
                    ->setOptions([
                        'actions' => (new RowActionCollection())
                            ->add((new LinkRowAction('edit'))
                                    ->setName($this->trans('Edit', [], 'Modules.Advideoblock.Admin'))
                                    ->setIcon('edit')
                                    ->setOptions([
                                        'route' => 'admin_ad_videoblock_edit',
                                        'route_param_name' => 'id',
                                        'route_param_field' => 'id',
                                        'clickable_row' => true
                                    ])
                            )
                            ->add((new SubmitRowAction('delete'))
                                    ->setName($this->trans('Delete', [], 'Modules.Advideoblock.Admin'))
                                    ->setIcon('delete')
                                    ->setOptions([
                                        'method' => 'DELETE',
                                        'route' => 'admin_ad_videoblock_delete',
                                        'route_param_name' => 'id',
                                        'route_param_field' => 'id',
                                        'confirm_message' => $this->trans('Are you sure you want to delete the video block ?', [], 'Modules.Advideoblock.Admin'),
                                        'modal_options' => new ModalOptions([
                                            'title' => $this->trans('Delete videoblock', [], 'Modules.Advideoblock.Admin'),
                                            'confirm_button_label' => $this->trans('Delete', [], 'Modules.Advideoblock.Admin'),
                                            'confirm_button_class' => 'btn-danger',
                                            'close_button_label' => $this->trans('Close', [], 'Modules.Advideoblock.Admin')
                                        ])
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
            ->add((new Filter('title', TextType::class))
                ->setAssociatedColumn('title')
                ->setTypeOptions([
                        'required' => false,
                        'attr' => ['placeholder' => $this->trans('Search title', [], 'Modules.Advideoblock.Admin')]
                    ])
            )
            ->add((new Filter('subtitle', TextType::class))
                ->setAssociatedColumn('subtitle')
                ->setTypeOptions([
                    'required' => false,
                    'attr' => ['placeholder' => $this->trans('Search subtitle', [], 'Modules.Advideoblock.Admin')]
                ])
            )
            ->add((new Filter('description', TextType::class))
                ->setAssociatedColumn('description')
                ->setTypeOptions([
                        'required' => false,
                        'attr' => ['placeholder' => $this->trans('Search description', [], 'Modules.Advideoblock.Admin')]
                    ])
            )
            ->add((new Filter('category', TextType::class))
                ->setAssociatedColumn('category')
                ->setTypeOptions([
                    'required' => false,
                    'attr' => ['placeholder' => $this->trans('Search category', [], 'Modules.Advideoblock.Admin')]
                ])
            )
            ->add((new Filter('fullscreen', YesAndNoChoiceType::class))
                    ->setAssociatedColumn('fullscreen')
            )
            ->add((new Filter('active', YesAndNoChoiceType::class))
                    ->setAssociatedColumn('active')
            )
            ->add((new Filter('actions', SearchAndResetType::class))
                ->setAssociatedColumn('actions')
                ->setTypeOptions([
                        'reset_route' => 'admin_common_reset_search_by_filter_id',
                        'reset_route_params' => ['filterId' => self::GRID_ID],
                        'redirect_route' => 'admin_ad_videoblock_index'
                    ])
            );
    }

    /**
     * @return BulkActionCollection|BulkActionCollectionInterface
     */
    protected function getBulkActions()
    {
        return (new BulkActionCollection())
            ->add((new EnableBulkAction('enable_selection'))
                ->setName($this->trans('Enable selection', [], 'Modules.Advideoblock.Admin'))
                ->setOptions([
                    'submit_route' => 'admin_ad_videoblock_active_bulk',
                    'route_params' => ['status' => true],
                    'confirm_message' => $this->trans('Are you sure you want to enable the selected video block(s) ?', [], 'Modules.Advideoblock.Admin'),
                    'modal_options' => new ModalOptions([
                        'title' => $this->trans('Enable video block(s) selection', [], 'Modules.Advideoblock.Admin'),
                        'confirm_button_label' => $this->trans('Enable selection', [], 'Modules.Advideoblock.Admin'),
                        'confirm_button_class' => 'btn-success'
                    ])
                ])
            )
            ->add((new DisableBulkAction('disable_selection'))
                ->setName($this->trans('Disable selection', [], 'Modules.Advideoblock.Admin'))
                ->setOptions([
                    'submit_route' => 'admin_ad_videoblock_active_bulk',
                    'route_params' => ['status' => false],
                    'confirm_message' => $this->trans('Are you sure you want to disable the selected video block(s) ?', [], 'Modules.Advideoblock.Admin'),
                    'modal_options' => new ModalOptions([
                        'title' => $this->trans('Disable video block(s) selection', [], 'Modules.Advideoblock.Admin'),
                        'confirm_button_label' => $this->trans('Disable selection', [], 'Modules.Advideoblock.Admin'),
                        'confirm_button_class' => 'btn-warning'
                    ])
                ])
            )
            ->add(new DividerBulkAction('divider1'))
            ->add((new EnableBulkAction('allow_fullscreen_selection'))
                ->setName($this->trans('Allow fullscreen selection', [], 'Modules.Advideoblock.Admin'))
                ->setOptions([
                    'submit_route' => 'admin_ad_videoblock_fullscreen_bulk',
                    'route_params' => ['status' => true],
                    'confirm_message' => $this->trans('Are you sure you want to allow fullscreen on the selected video block(s) ?', [], 'Modules.Advideoblock.Admin'),
                    'modal_options' => new ModalOptions([
                        'title' => $this->trans('Allow fullscreen on video block(s) selection', [], 'Modules.Advideoblock.Admin'),
                        'confirm_button_label' => $this->trans('Allow fullscreen on selection', [], 'Modules.Advideoblock.Admin'),
                        'confirm_button_class' => 'btn-success'
                    ])
                ])
            )
            ->add((new DisableBulkAction('forbid_fullscreen_selection'))
                ->setName($this->trans('Forbid fullscreen selection', [], 'Modules.Advideoblock.Admin'))
                ->setOptions([
                    'submit_route' => 'admin_ad_videoblock_fullscreen_bulk',
                    'route_params' => ['status' => false],
                    'confirm_message' => $this->trans('Are you sure you want to forbid fullscreen on the selected video block(s) ?', [], 'Modules.Advideoblock.Admin'),
                    'modal_options' => new ModalOptions([
                        'title' => $this->trans('Forbid fullscreen on video block(s) selection', [], 'Modules.Advideoblock.Admin'),
                        'confirm_button_label' => $this->trans('Forbid fullscreen on selection', [], 'Modules.Advideoblock.Admin'),
                        'confirm_button_class' => 'btn-warning'
                    ])
                ])
            )
            ->add(new DividerBulkAction('divider2'))
            ->add((new DuplicateBulkAction('duplicate_selection'))
                ->setName($this->trans('Duplicate selection', [], 'Modules.Advideoblock.Admin'))
                ->setOptions([
                    'submit_route' => 'admin_ad_videoblock_duplicate_bulk',
                    'confirm_message' => $this->trans('Are you sure you want to duplicate the selected video block(s) ?', [], 'Modules.Advideoblock.Admin'),
                    'modal_options' => new ModalOptions([
                        'title' => $this->trans('Duplicate video block(s) selection', [], 'Modules.Advideoblock.Admin'),
                        'confirm_button_label' => $this->trans('Duplicate selection', [], 'Modules.Advideoblock.Admin'),
                        'confirm_button_class' => 'btn-success'
                    ])
                ])
            )
            ->add(new DividerBulkAction('divider3'))
            ->add((new DeleteBulkAction('delete_selection'))
                ->setName($this->trans('Delete selection', [], 'Modules.Advideoblock.Admin'))
                ->setOptions([
                    'submit_route' => 'admin_ad_videoblock_delete_bulk',
                    'confirm_message' => $this->trans('Are you sure you want to delete the selected video block(s) ?', [], 'Modules.Advideoblock.Admin'),
                    'modal_options' => new ModalOptions([
                        'title' => $this->trans('Delete video block(s) selection', [], 'Modules.Advideoblock.Admin'),
                        'confirm_button_label' => $this->trans('Delete selection', [], 'Modules.Advideoblock.Admin'),
                        'confirm_button_class' => 'btn-danger'
                    ])
                ])
            );
    }
}
