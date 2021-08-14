<?php
/*
 * This file is part of the Desksheet project.
 *
 * (c) Mohamed Radhi GUENNICHI <hello@guennichi.com> (https://www.guennichi.com)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Desksheet\Module\Expense\Repository;

use Desksheet\Module\Expense\Model\Account;
use Desksheet\Module\User\Model\UserInterface;
use Desksheet\System\Repository\ORM\ResourceRepository;

class AccountRepository extends ResourceRepository
{
    /**
     * @param UserInterface $user
     *
     * @return Account[]
     */
    public function findByUser(UserInterface $user): array
    {
        $queryBuilder = $this->createQueryBuilder('a');

        $queryBuilder
            ->andWhere(
                $queryBuilder->expr()->eq('a.user', ':user')
            )
            ->setParameter('user', $user)
            ->addOrderBy('a.createdAt', 'DESC');

        return $queryBuilder
            ->getQuery()
            ->getResult();
    }
}
