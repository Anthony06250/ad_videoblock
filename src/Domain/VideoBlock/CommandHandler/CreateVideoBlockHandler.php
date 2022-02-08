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

use AdVideoBlock\Domain\VideoBlock\Command\CreateVideoBlockCommand;
use AdVideoBlock\Domain\VideoBlock\Exception\CannotCreateVideoBlockException;
use AdVideoBlock\Domain\VideoBlock\ValueObject\VideoBlockId;
use AdVideoBlock\Repository\VideoBlockRepository;
use PrestaShopException;

class CreateVideoBlockHandler extends AbstractVideoBlockHandler
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
     * @param CreateVideoBlockCommand $command
     * @return VideoBlockId
     * @throws CannotCreateVideoBlockException
     */
    public function handle(CreateVideoBlockCommand $command): VideoBlockId
    {
        $id = $this->repository->findLastId() + 1;
        $videoblock = $this->createVideoBlock($id);

        $videoblock->fromArray($command->toArray());
        $videoblock->id_ad_videoblock = $id;

        try {
            if (false === $videoblock->update()) {
                throw new CannotCreateVideoBlockException(
                    sprintf('Failed to create videoblock with id "%s"', $videoblock->id)
                );
            }
        } catch (PrestaShopException $exception) {
            throw new CannotCreateVideoBlockException(
                'An unexpected error occurred when create videoblock'
            );
        }
        return new VideoBlockId($id);
    }
}