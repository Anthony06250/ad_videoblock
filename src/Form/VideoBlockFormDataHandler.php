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

use AdVideoBlock\Domain\VideoBlock\Command\CreateVideoBlockCommand;
use AdVideoBlock\Domain\VideoBlock\Command\EditVideoBlockCommand;
use PrestaShop\PrestaShop\Core\CommandBus\CommandBusInterface;
use PrestaShop\PrestaShop\Core\Form\IdentifiableObject\DataHandler\FormDataHandlerInterface;
use PrestaShopException;

final class VideoBlockFormDataHandler implements FormDataHandlerInterface
{
    /**
     * @var CommandBusInterface
     */
    private $command_bus;

    /**
     * @param CommandBusInterface $command_bus
     */
    public function __construct(CommandBusInterface $command_bus)
    {
        $this->command_bus = $command_bus;
    }

    /**
     * @param array $data
     * @return int
     * @throws PrestaShopException
     */
    public function create(array $data): int
    {
        $command = new CreateVideoBlockCommand();
        $videoblock = $this->command_bus->handle($command->fromArray($data));

        return $videoblock->getValue();
    }

    /**
     * @param $id
     * @param array $data
     * @return void
     */
    public function update($id, array $data): void
    {
        $command = new EditVideoBlockCommand((int)$id);

        $this->command_bus->handle($command->fromArray($data));
    }
}
