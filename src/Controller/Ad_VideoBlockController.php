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

namespace AdVideoBlock\Controller;

use AdVideoBlock\Domain\VideoBlock\Command\DeleteVideoBlockCommand;
use AdVideoBlock\Grid\Factory\VideoBlockGridDefinitionFactory;
use AdVideoBlock\Grid\Filters\VideoBlockFilters;
use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Ad_VideoBlockController extends FrameworkBundleAdminController
{
    /**
     * @AdminSecurity("is_granted('read', request.get('_legacy_controller'))", message="Access denied.")
     * @param VideoBlockFilters $filters
     * @return Response
     */
    public function indexAction(VideoBlockFilters $filters): Response
    {
        $gridFactory = $this->get('advideoblock.grid.factory.videoblock_grid_factory');
        $grid = $gridFactory->getGrid($filters);

        return $this->render('@Modules/ad_videoblock/views/templates/admin/index.html.twig', [
                'layoutHeaderToolbarBtn' => $this->getToolbarButtons(),
                'grid' => $this->presentGrid($grid),
            ]
        );
    }

    /**
     * @AdminSecurity("is_granted('read', request.get('_legacy_controller'))", message="Access denied.")
     * @param Request $request
     * @return RedirectResponse
     */
    public function searchAction(Request $request): RedirectResponse
    {
        $response = $this->get('prestashop.bundle.grid.response_builder');

        return $response->buildSearchResponse($this->get('advideoblock.grid.factory.videoblock_grid_definition_factory'),
            $request,
            VideoBlockGridDefinitionFactory::GRID_ID,
            'admin_ad_videoblock_index'
        );
    }

    /**
     * @AdminSecurity("is_granted('create', request.get('_legacy_controller'))", message="Access denied.")
     * @param Request $request
     * @return Response
     */
    public function createAction(Request $request): Response
    {
        $formBuilder = $this->get('advideoblock.form.videoblock_form_builder');
        $form = $formBuilder->getForm();

        $form->handleRequest($request);

        $formHandler = $this->get('advideoblock.form.videoblock_form_handler');
        $result = $formHandler->handle($form);

        if (null !== $result->getIdentifiableObjectId()) {
            $this->addFlash('success', $this->trans('Successful creation.', 'Modules.Advideoblock.Admin'));

            return $this->redirectToRoute('admin_ad_videoblock_index');
        }

        return $this->render('@Modules/ad_videoblock/views/templates/admin/edit.html.twig', [
            'layoutHeaderToolbarBtn' => $this->getToolbarButtons(),
            'form' => $form->createView()
        ]);
    }

    /**
     * @AdminSecurity("is_granted('update', request.get('_legacy_controller'))", message="Access denied.")
     * @param int $id
     * @param Request $request
     * @return Response
     */
    public function editAction(int $id, Request $request): Response
    {
        $formBuilder = $this->get('advideoblock.form.videoblock_form_builder');
        $form = $formBuilder->getFormFor($id);

        $form->handleRequest($request);

        $formHandler = $this->get('advideoblock.form.videoblock_form_handler');
        $result = $formHandler->handleFor($id, $form);

        if ($result->isSubmitted() && $result->isValid()) {
            $this->addFlash('success', $this->trans('Successful update.', 'Modules.Advideoblock.Admin'));

            return $this->redirectToRoute('admin_ad_videoblock_index');
        }

        return $this->render('@Modules/ad_videoblock/views/templates/admin/edit.html.twig', [
            'layoutHeaderToolbarBtn' => $this->getToolbarButtons(),
            'form' => $form->createView(),
        ]);
    }

    /**
     * @AdminSecurity("is_granted('delete', request.get('_legacy_controller'))", message="Access denied.")
     * @param int $id
     * @return RedirectResponse
     */
    public function deleteAction(int $id): RedirectResponse
    {
        $handler = $this->get('advideoblock.domain.videoblock.command_handler.delete_videoblock_handler');

        $handler->handle(new DeleteVideoBlockCommand($id));
        $this->addFlash('success', $this->trans('Video Block has been successfully deleted.', 'Modules.Advideoblock.Admin'));

        return $this->redirectToRoute('admin_ad_videoblock_index');
    }

    /**
     * @AdminSecurity("is_granted('delete', request.get('_legacy_controller'))", message="Access denied.")
     * @param Request $request
     * @return RedirectResponse
     */
    public function deleteBulkAction(Request $request): RedirectResponse
    {
        $videoblockIds = $request->request->get('videoblock_bulk_action');
        $handler = $this->get('advideoblock.domain.videoblock.command_handler.delete_videoblock_handler');

        foreach ($videoblockIds as $id) {
            $handler->handle(new DeleteVideoBlockCommand((int)$id));
        }

        $this->addFlash('success', $this->trans('The selection has been successfully deleted.', 'Modules.Advideoblock.Admin'));

        return $this->redirectToRoute('admin_ad_videoblock_index');
    }

    /**
     * @return array[]
     */
    private function getToolbarButtons(): array
    {
        return [
            'add' => [
                'href' => $this->generateUrl('admin_ad_videoblock_create'),
                'desc' => $this->trans('New Video Block', 'Modules.Advideoblock.Admin'),
                'icon' => 'add_circle_outline',
            ],
        ];
    }
}
