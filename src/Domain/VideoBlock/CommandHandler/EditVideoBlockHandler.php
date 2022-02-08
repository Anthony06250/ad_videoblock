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

namespace AdVideoBlock\Domain\VideoBlock\CommandHandler;

use AdVideoBlock\Domain\VideoBlock\Command\EditVideoBlockCommand;
use AdVideoBlock\Domain\VideoBlock\Exception\CannotCreateVideoBlockException;
use AdVideoBlock\Domain\VideoBlock\Exception\CannotEditVideoBlockException;
use AdVideoBlock\Model\VideoBlock;
use AdVideoBlock\Repository\VideoBlockRepository;
use PrestaShopException;

class EditVideoBlockHandler extends AbstractVideoBlockHandler
{
    /**
     * @var VideoBlockRepository
     */
    private $repository;

    /**
     * @param VideoBlockRepository $repository
     */
    public function __construct(VideoBlockRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param EditVideoBlockCommand $command
     * @return void
     * @throws CannotCreateVideoBlockException
     * @throws CannotEditVideoBlockException
     * @throws PrestaShopException
     */
    public function handle(EditVideoBlockCommand $command): void
    {
        $id = $this->repository->findById($command->getId()->getValue())['id_ad_videoblock'];
        $videoblock = new VideoBlock($id);

        if (0 >= $videoblock->id) {
            $videoblock = $this->createVideoBlock($command->getId()->getValue());
        }

        $videoblock->fromArray($command->toArray());

        try {
            if (false === $videoblock->update()) {
                throw new CannotEditVideoBlockException(
                    sprintf('Failed to update videoblock with id "%s"', $videoblock->id)
                );
            }
        } catch (PrestaShopException $exception) {
            throw new CannotEditVideoBlockException(
                'An unexpected error occurred when updating videoblock'
            );
        }
    }
}
