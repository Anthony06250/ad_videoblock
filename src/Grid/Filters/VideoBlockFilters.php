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

namespace AdVideoBlock\Grid\Filters;

use AdVideoBlock\Grid\Factory\VideoBlockGridDefinitionFactory;
use PrestaShop\PrestaShop\Core\Search\Filters;

final class VideoBlockFilters extends Filters
{
    /**
     * -> TODO: Filter getDefaults not work... WHY ???
     */

    /**
     * @var string
     */
    protected $filterId = VideoBlockGridDefinitionFactory::GRID_ID;

    /**
     * @return array
     */
    public static function getDefaults(): array
    {
        return [
            'limit' => 5,
            'offset' => 0,
            'orderBy' => 'id',
            'sortOrder' => 'asc',
            'filters' => [],
        ];
    }
}
