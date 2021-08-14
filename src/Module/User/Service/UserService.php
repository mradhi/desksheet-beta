<?php
/*
 * This file is part of the Desksheet project.
 *
 * (c) Mohamed Radhi GUENNICHI <hello@guennichi.com> (https://www.guennichi.com)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Desksheet\Module\User\Service;

use Desksheet\Module\User\Factory\UserFactory;
use Desksheet\Module\User\Model\UserInterface;
use Desksheet\Module\User\Repository\UserRepository;
use Desksheet\Module\User\Util\UserPasswordUpdater;
use Desksheet\System\Aware\ResourceManagerAware;

class UserService
{
    use ResourceManagerAware;

    public function __construct(
        private UserPasswordUpdater $passwordUpdater,
        private UserRepository $userRepository,
        private UserFactory $userFactory
    )
    {
    }

    public function findByUsername(?string $username): ?UserInterface
    {
        // Maybe canonicalize the username before searching.
        return $this->userRepository->findByUsername($username);
    }

    public function findById(int $id): ?UserInterface
    {
        return $this->userRepository->findById($id);
    }

    public function update(UserInterface $user): void
    {
        $this->passwordUpdater->updatePassword($user);
        $this->resourceManager->importAndFlush($user);
    }

    public function newUser(): UserInterface
    {
        return $this->userFactory->createNew();
    }
}
