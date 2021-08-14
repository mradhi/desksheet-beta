<?php
/*
 * This file is part of the Desksheet project.
 *
 * (c) Mohamed Radhi GUENNICHI <hello@guennichi.com> (https://www.guennichi.com)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Desksheet\Module\User\Util;

use Desksheet\Module\User\Model\UserInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserPasswordUpdater
{
    public function __construct(private UserPasswordHasherInterface $userPasswordHasher)
    {
    }

    public function updatePassword(UserInterface $user): void
    {
        if (!empty($user->getPlainPassword())) {
            $user->setPassword(
                $this->userPasswordHasher->hashPassword($user, $user->getPlainPassword())
            );
            $user->eraseCredentials();
        }
    }
}
