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

namespace AdVideoBlock\Repository;

use Doctrine\DBAL\Connection;
use PDO;

class VideoBlockRepository
{
    /**
     * @var Connection the Database connection.
     */
    private $connection;

    /**
     * @var string the Database name.
     */
    private $database_name;

    /**
     * @param Connection $connection
     * @param $database_prefix
     */
    public function __construct(Connection $connection, $database_prefix)
    {
        $this->connection = $connection;
        $this->database_name = $database_prefix . 'ad_videoblock';
    }

    /**
     * @return array
     */
    public function findAll(): array
    {
        $query = $this->connection->createQueryBuilder();

        $query
            ->select('*')
            ->from($this->database_name)
        ;

        return $query->execute()->fetchAll();
    }

    /**
     * @param int $id
     * @return array
     */
    public function findById(int $id): array
    {
        $query = $this->connection->createQueryBuilder();

        $query
            ->select('*')
            ->from($this->database_name)
            ->where('`id_ad_videoblock` = :id')
        ;
        $query->setParameter('id', $id);

        return $query->execute()->fetch();
    }

    /**
     * @param int $id
     * @return array
     */
    public function findAllByCategoryId(int $id): array
    {
        $query = $this->connection->createQueryBuilder();

        $query
            ->select('*')
            ->from($this->database_name)
            ->where('`id_category` = :id')
        ;
        $query->setParameter('id', $id);

        return $query->execute()->fetchAll();
    }

    /**
     * @return int
     */
    public function findLastId(): int
    {
        $query = $this->connection->createQueryBuilder();

        $query
            ->select('id_ad_videoblock')
            ->from($this->database_name)
            ->orderBy('id_ad_videoblock', 'DESC')
        ;

        return (int)$query->execute()->fetch(PDO::FETCH_COLUMN);
    }
}
