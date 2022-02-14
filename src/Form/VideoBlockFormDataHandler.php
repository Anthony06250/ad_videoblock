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
use AdVideoBlock\Domain\VideoBlock\Exception\VideoBlockException;
use PrestaShop\PrestaShop\Core\CommandBus\CommandBusInterface;
use PrestaShop\PrestaShop\Core\Form\IdentifiableObject\DataHandler\FormDataHandlerInterface;

final class VideoBlockFormDataHandler implements FormDataHandlerInterface
{
    /**
     * @var CommandBusInterface
     */
    private $commandBus;

    /**
     * @param CommandBusInterface $commandBus
     */
    public function __construct(CommandBusInterface $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * @param array $data
     * @return int
     * @throws VideoBlockException
     */
    public function create(array $data): int
    {
        $command = new CreateVideoBlockCommand();
        $data['url'] = $this->getYoutubeIdFromUrl($data['url']);
        $videoblock = $this->commandBus->handle($command->fromArray($data));

        return $videoblock->getValue();
    }

    /**
     * @param $id
     * @param array $data
     * @return void
     * @throws VideoBlockException
     */
    public function update($id, array $data): void
    {
        $command = new EditVideoBlockCommand((int)$id);
        $data['url'] = $this->getYoutubeIdFromUrl($data['url']);

        $this->commandBus->handle($command->fromArray($data));
    }

    /**
     * @param string $url
     * @return string
     * @throws VideoBlockException
     */
    private function getYoutubeIdFromUrl(string $url): string
    {
        $regex = '~
            ^(?:https?://)?                           # Optional protocol
            (?:www[.])?                              # Optional sub-domain
            (?:youtube[.]com/watch[?]v=|youtu[.]be/) # Mandatory domain name (w/ query string in .com)
            ([^&]{11})                               # Video id of 11 characters as capture group 1
            ~x';
        // Source : https://stackoverflow.com/questions/13476060/validating-youtube-url-using-regex

        if (!preg_match($regex, $url, $result)) {
            throw new VideoBlockException(
                sprintf('%s is not a valid Youtube url.', $url)
            );
        }

        return $result[1];
    }
}
