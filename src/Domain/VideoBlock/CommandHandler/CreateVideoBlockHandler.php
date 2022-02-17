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
use AdVideoBlock\Model\VideoBlock;
use PrestaShopException;

final class CreateVideoBlockHandler
{
    /**
     * @param CreateVideoBlockCommand $command
     * @return VideoBlockId
     * @throws CannotCreateVideoBlockException
     */
    public function handle(CreateVideoBlockCommand $command): VideoBlockId
    {
        $videoblock = new VideoBlock();

        $videoblock->hydrate($command->toArray());

        try {
            if (false === $videoblock->add()) {
                throw new CannotCreateVideoBlockException(
                    sprintf('Failed to create video block with id "%s"', $videoblock->id)
                );
            }
        } catch (PrestaShopException $exception) {
            throw new CannotCreateVideoBlockException(
                'An unexpected error occurred when create video block'
            );
        }

        return $command->getId()->setValue((int)$videoblock->id);
    }
}
