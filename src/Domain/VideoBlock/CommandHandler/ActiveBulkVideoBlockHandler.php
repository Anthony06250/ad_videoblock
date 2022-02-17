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

use AdVideoBlock\Domain\VideoBlock\Command\ActiveBulkVideoBlockCommand;
use AdVideoBlock\Domain\VideoBlock\Exception\CannotActiveBulkVideoBlockException;
use AdVideoBlock\Model\VideoBlock;
use PrestaShopException;

final class ActiveBulkVideoBlockHandler
{
    /**
     * @param ActiveBulkVideoBlockCommand $command
     * @return void
     */
    public function handle(ActiveBulkVideoBlockCommand $command): void
    {
        $ids = $command->getId()->getValue();
        $status = $command->getStatus();

        try {
            if (false === (new VideoBlock())->activeSelection($ids, $status)) {
                throw new CannotActiveBulkVideoBlockException(
                    sprintf('Failed to enable video blocks with ids "%s"', implode(', ', $ids))
                );
            }
        } catch (PrestaShopException $exception) {
            throw new CannotActiveBulkVideoBlockException(
                'An unexpected error occurred when enable video blocks'
            );
        }
    }
}
