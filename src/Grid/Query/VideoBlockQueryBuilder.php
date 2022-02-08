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
        $qb = $this->getQueryBuilder($searchCriteria->getFilters());
        $qb->select('p.`id_ad_videoblock`, p.`id_category`, p.`block_title`, p.`video_path`, p.`video_title`, p.`video_fullscreen`');

        $this->searchCriteriaApplicator
            ->applyPagination($searchCriteria, $qb)
            ->applySorting($searchCriteria, $qb);

        return $qb;
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return QueryBuilder
     */
    public function getCountQueryBuilder(SearchCriteriaInterface $searchCriteria): QueryBuilder
    {
        $qb = $this->getQueryBuilder($searchCriteria->getFilters());
        $qb->select('COUNT(p.`id_ad_videoblock`)');

        return $qb;
    }

    /**
     * @param array $filters
     * @return QueryBuilder
     */
    private function getQueryBuilder(array $filters): QueryBuilder
    {
        $qb = $this->connection
            ->createQueryBuilder()
            ->from($this->dbPrefix . 'ad_videoblock', 'p');


        foreach ($filters as $filterName => $filter) {
            if ('id_ad_videoblock' === $filterName) {
                $qb->andWhere('p.`id_ad_videoblock` = :id_ad_videoblock');
                $qb->setParameter('id_ad_videoblock', $filter);

                continue;
            }

            if ('id_category' === $filterName) {
                $qb->andWhere('p.`id_category` = :id_category');
                $qb->setParameter('id_category', $filter);

                continue;
            }

            if ('block_title' === $filterName) {
                $qb->andWhere('p.`block_title` LIKE :block_title');
                $qb->setParameter('block_title', '%' . $filter . '%');

                continue;
            }

            if ('video_path' === $filterName) {
                $qb->andWhere('p.`video_path` LIKE :video_path');
                $qb->setParameter('video_path', '%' . $filter . '%');

                continue;
            }

            if ('video_title' === $filterName) {
                $qb->andWhere('p.`video_title` LIKE :video_title');
                $qb->setParameter('video_title', '%' . $filter . '%');

                continue;
            }

            if ('video_fullscreen' === $filterName) {
                $qb->andWhere('p.`video_fullscreen` LIKE :video_fullscreen');
                $qb->setParameter('video_fullscreen', '%' . $filter . '%');

                continue;
            }
        }

        return $qb;
    }
}