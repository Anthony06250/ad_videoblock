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

namespace AdVideoBlock\Grid\Query;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use PrestaShop\PrestaShop\Core\Grid\Query\AbstractDoctrineQueryBuilder;
use PrestaShop\PrestaShop\Core\Grid\Query\DoctrineSearchCriteriaApplicatorInterface;
use PrestaShop\PrestaShop\Core\Grid\Search\SearchCriteriaInterface;

class VideoBlockQueryBuilder extends AbstractDoctrineQueryBuilder
{
    /**
     * @var int
     */
    private $contextLanguageId;

    /**
     * @var int
     */
    private $contextShopId;

    /**
     * @var DoctrineSearchCriteriaApplicatorInterface
     */
    private $searchCriteriaApplicator;

    /**
     * @param Connection $connection
     * @param string $dbPrefix
     * @param int $contextLanguageId
     * @param int $contextShopId
     * @param DoctrineSearchCriteriaApplicatorInterface $searchCriteriaApplicator
     */
    public function __construct(
        Connection $connection,
        string $dbPrefix,
        int $contextLanguageId,
        int $contextShopId,
        DoctrineSearchCriteriaApplicatorInterface $searchCriteriaApplicator
    ) {
        parent::__construct($connection, $dbPrefix);
        $this->contextLanguageId = $contextLanguageId;
        $this->contextShopId = $contextShopId;
        $this->searchCriteriaApplicator = $searchCriteriaApplicator;
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return QueryBuilder
     */
    public function getSearchQueryBuilder(SearchCriteriaInterface $searchCriteria): QueryBuilder
    {
        $query = $this->getQueryBuilder($searchCriteria->getFilters());

        $query->select('p.`id_ad_videoblock` AS `id`, p.`block_title`, p.`video_path`, p.`video_title`, p.`block_subtitle`,p.`video_fullscreen`, p.`active`')
            ->addSelect('pl.`name` AS `category`');
        $this->searchCriteriaApplicator
            ->applyPagination($searchCriteria, $query)
            ->applySorting($searchCriteria, $query);

        return $query;
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return QueryBuilder
     */
    public function getCountQueryBuilder(SearchCriteriaInterface $searchCriteria): QueryBuilder
    {
        $query = $this->getQueryBuilder($searchCriteria->getFilters());
        $query->select('COUNT(p.`id_ad_videoblock`)');

        return $query;
    }

    /**
     * @param array $filters
     * @return QueryBuilder
     */
    private function getQueryBuilder(array $filters): QueryBuilder
    {
        $query = $this->connection
            ->createQueryBuilder()
            ->from($this->dbPrefix . 'ad_videoblock', 'p')
            ->innerJoin(
                'p',
                $this->dbPrefix . 'category_shop',
                'ps',
                'ps.`id_category` = p.`id_category` AND ps.`id_shop` = :id_shop'
            )
            ->leftJoin(
                'p',
                $this->dbPrefix . 'category_lang',
                'pl',
                'pl.`id_category` = p.`id_category` AND pl.`id_lang` = :id_lang AND pl.`id_shop` = :id_shop'
            )
            ->setParameter('id_lang', $this->contextLanguageId)
            ->setParameter('id_shop', $this->contextShopId);

        foreach ($filters as $filterName => $filter) {
            dump($filter);
            if ('category' === $filterName) {
                $query->andWhere('pl.`name` LIKE :category');
                $query->setParameter('category', '%' . $filter . '%');

                continue;
            }

            if ('block_title' === $filterName) {
                $query->andWhere('p.`block_title` LIKE :block_title');
                $query->setParameter('block_title', '%' . $filter . '%');

                continue;
            }

            if ('block_subtitle' === $filterName) {
                $query->andWhere('p.`block_subtitle` LIKE :block_subtitle');
                $query->setParameter('block_subtitle', '%' . $filter . '%');

                continue;
            }

            if ('video_title' === $filterName) {
                $query->andWhere('p.`video_title` LIKE :video_title');
                $query->setParameter('video_title', '%' . $filter . '%');

                continue;
            }

            if ('video_fullscreen' === $filterName) {
                $query->andWhere('p.`video_fullscreen` LIKE :video_fullscreen');
                $query->setParameter('video_fullscreen', '%' . $filter . '%');

                continue;
            }

            if ('active' === $filterName) {
                $query->andWhere('p.`active` LIKE :active');
                $query->setParameter('active', '%' . $filter . '%');

                continue;
            }
        }

        return $query;
    }
}
