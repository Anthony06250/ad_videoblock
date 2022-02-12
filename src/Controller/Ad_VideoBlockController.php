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

use AdVideoBlock\Domain\VideoBlock\Command\DeleteBulkVideoBlockCommand;
use AdVideoBlock\Domain\VideoBlock\Command\DeleteVideoBlockCommand;
use AdVideoBlock\Domain\VideoBlock\Command\ToggleFullscreenVideoBlockCommand;
use AdVideoBlock\Domain\VideoBlock\Command\ToggleStatusVideoBlockCommand;
use AdVideoBlock\Domain\VideoBlock\Exception\VideoBlockException;
use AdVideoBlock\Grid\Filters\VideoBlockFilters;
use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;
use PrestaShopBundle\Security\Annotation\AdminSecurity;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Ad_VideoBlockController extends FrameworkBundleAdminController
{
    /**
     * -> TODO: Make enableBulkAction, disableBulkAction and duplicateBulkAction functions
     */

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
     * @AdminSecurity("is_granted('create', request.get('_legacy_controller'))", message="Access denied.")
     * @param Request $request
     * @return Response
     */
    public function createAction(Request $request): Response
    {
        $form = $this->get('advideoblock.form.videoblock_form_builder')->getForm();
        $formHandler = $this->get('advideoblock.form.videoblock_form_handler');

        $form->handleRequest($request);

        try {
            $result = $formHandler->handle($form);

            if (null !== $result->getIdentifiableObjectId()) {
                $this->addFlash('success', $this->trans('The videoblock has been successfully created.', 'Modules.Advideoblock.Admin'));

                return $this->redirectToRoute('admin_ad_videoblock_index');
            }
        } catch (VideoBlockException $exception) {
            $this->addFlash('error', $this->trans($exception->getMessage(), 'Modules.Advideoblock.Admin'));
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
        $form = $this->get('advideoblock.form.videoblock_form_builder')->getFormFor($id);
        $formHandler = $this->get('advideoblock.form.videoblock_form_handler');

        $form->handleRequest($request);

        try {
            $result = $formHandler->handleFor($id, $form);

            if ($result->isSubmitted() && $result->isValid()) {
                $this->addFlash('success', $this->trans('The videoblock has been successfully updated.', 'Modules.Advideoblock.Admin'));

                return $this->redirectToRoute('admin_ad_videoblock_index');
            }
        } catch (VideoBlockException $exception) {
            $this->addFlash('error', $this->trans($exception->getMessage(), 'Modules.Advideoblock.Admin'));
        }

        return $this->render('@Modules/ad_videoblock/views/templates/admin/edit.html.twig', [
            'layoutHeaderToolbarBtn' => $this->getToolbarButtons(),
            'form' => $form->createView(),
        ]);
    }

    /**
     * @AdminSecurity("is_granted('delete', request.get('_legacy_controller'))", message="Access denied.")
     * @param Request $request
     * @return RedirectResponse
     */
    public function deleteAction(Request $request): RedirectResponse
    {
        $id = (int)$request->get('id');
        $handler = $this->get('advideoblock.domain.videoblock.command_handler.delete_videoblock_handler');

        try {
            $handler->handle(new DeleteVideoBlockCommand($id));
            $this->addFlash('success', $this->trans('Video Block has been successfully deleted.', 'Modules.Advideoblock.Admin'));
        } catch (VideoBlockException $exception) {
            $this->addFlash('error', $this->trans($exception->getMessage(), 'Modules.Advideoblock.Admin'));
        }

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
        $handler = $this->get('advideoblock.domain.videoblock.command_handler.delete_bulk_videoblock_handler');

        try {
            $handler->handle(new DeleteBulkVideoBlockCommand($videoblockIds));
            $this->addFlash('success', $this->trans('The selection has been successfully deleted.', 'Modules.Advideoblock.Admin'));
        } catch (VideoBlockException $exception) {
            $this->addFlash('error', $this->trans($exception->getMessage(), 'Modules.Advideoblock.Admin'));
        }

        return $this->redirectToRoute('admin_ad_videoblock_index');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function enableBulkAction(Request $request): RedirectResponse
    {
        return $this->redirectToRoute('admin_ad_videoblock_index');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function disableBulkAction(Request $request): RedirectResponse
    {
        return $this->redirectToRoute('admin_ad_videoblock_index');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function duplicateBulkAction(Request $request): RedirectResponse
    {
        return $this->redirectToRoute('admin_ad_videoblock_index');
    }

    /**
     * @AdminSecurity("is_granted('update', request.get('_legacy_controller'))", message="Access denied.")
     * @param int $id
     * @return JsonResponse
     */
    public function toggleFullscreenAction(int $id): JsonResponse
    {
        $handler = $this->get('advideoblock.domain.videoblock.command_handler.toggle_fullscreen_videoblock_handler');

        try {
            $handler->handle(new ToggleFullscreenVideoBlockCommand($id));

            $response = [
                'status' => true,
                'message' => $this->trans('The videoblock status has been successfully updated.', 'Modules.Advideoblock.Admin'),
            ];
        } catch (VideoBlockException $exception) {
            $response = [
                'status' => false,
                'message' => $this->trans($exception->getMessage(), 'Modules.Advideoblock.Admin'),
            ];
        }

        return $this->json($response);
    }

    /**
     * @AdminSecurity("is_granted('update', request.get('_legacy_controller'))", message="Access denied.")
     * @param int $id
     * @return JsonResponse
     */
    public function toggleStatusAction(int $id): JsonResponse
    {
        $handler = $this->get('advideoblock.domain.videoblock.command_handler.toggle_status_videoblock_handler');

        try {
            $handler->handle(new ToggleStatusVideoBlockCommand($id));

            $response = [
                'status' => true,
                'message' => $this->trans('The videoblock status has been successfully updated.', 'Modules.Advideoblock.Admin'),
            ];
        } catch (VideoBlockException $exception) {
             $response = [
                'status' => false,
                'message' => $this->trans($exception->getMessage(), 'Modules.Advideoblock.Admin'),
            ];
        }

        return $this->json($response);
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
