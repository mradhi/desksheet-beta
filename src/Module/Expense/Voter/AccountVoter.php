<?php
/*
 * This file is part of the Desksheet project.
 *
 * (c) Mohamed Radhi GUENNICHI <hello@guennichi.com> (https://www.guennichi.com)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Desksheet\Module\Expense\Voter;

use Desksheet\Module\Expense\Model\AccountInterface;
use Desksheet\Module\User\Model\UserInterface;
use LogicException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class AccountVoter extends Voter
{
    public const EDIT = 'edit';
    public const DELETE = 'delete';

    /**
     * @inheritDoc
     */
    protected function supports(string $attribute, $subject): bool
    {
        // if the attribute isn't one we support, return false
        if (!in_array($attribute, [self::DELETE, self::EDIT])) {
            return false;
        }

        // only vote on `Post` objects
        if (!$subject instanceof AccountInterface) {
            return false;
        }

        return true;
    }

    /**
     * @inheritDoc
     */
    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        if (!$user instanceof UserInterface) {
            // the user must be logged in; if not, deny access
            return false;
        }

        /** @var AccountInterface $account */
        $account = $subject;

        switch ($attribute) {
            case self::DELETE:
                return $this->canDelete($account, $user);
            case self::EDIT:
                return $this->canEdit($account, $user);
        }

        throw new LogicException('This code should not be reached!');
    }

    private function canDelete(AccountInterface $account, UserInterface $user): bool
    {
        return $this->isOwner($account, $user);
    }

    private function canEdit(AccountInterface $account, UserInterface $user): bool
    {
        return $this->isOwner($account, $user);
    }

    private function isOwner(AccountInterface $account, UserInterface $user): bool
    {
        return $user === $account->getUser();
    }
}
