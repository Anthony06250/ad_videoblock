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

use AdVideoBlock\Domain\VideoBlock\Command\ToggleStatusVideoBlockCommand;
use AdVideoBlock\Domain\VideoBlock\Exception\CannotToggleStatusVideoBlockException;
use AdVideoBlock\Model\VideoBlock;
use PrestaShopDatabaseException;
use PrestaShopException;

class ToggleStatusVideoBlockHandler
{
    /**
     * @param ToggleStatusVideoBlockCommand $command
     * @return void
     * @throws CannotToggleStatusVideoBlockException
     * @throws PrestaShopException
     * @throws PrestaShopDatabaseException
     */
    public function handle(ToggleStatusVideoBlockCommand $command): void
    {
        $id = $command->getId()->getValue();
        $videoblock = new VideoBlock($id);

        try {
            if (false === $videoblock->toggleStatus()) {
                throw new CannotToggleStatusVideoBlockException(
                    sprintf('Failed to toggle status for videoblock with id "%s"', $videoblock->id)
                );
            }
        } catch (PrestaShopException $exception) {
            throw new CannotToggleStatusVideoBlockException(
                'An unexpected error occurred when toggle status of videoblock'
            );
        }
    }
}
