<?php
/*
 * This file is part of the Desksheet project.
 *
 * (c) Mohamed Radhi GUENNICHI <hello@guennichi.com> (https://www.guennichi.com)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Desksheet\System\Repository;

use Desksheet\System\Model\ResourceInterface;

interface ResourceRepositoryInterface
{
    public function add(ResourceInterface $resource): void;

    public function remove(ResourceInterface $resource): void;

    public function findById($resourceId): ?object;

    public function count(): int;

    public function findOneBy(array $criteria): ?object;
}
