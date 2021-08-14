<?php
/*
 * This file is part of the Desksheet project.
 *
 * (c) Mohamed Radhi GUENNICHI <hello@guennichi.com> (https://www.guennichi.com)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Desksheet\Module\User\Security\Provider;

use Desksheet\Module\User\Service\UserService;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Desksheet\Module\User\Model\UserInterface as DesksheetUserInterface;

class UserProvider implements UserProviderInterface
{
    public function __construct(private UserService $userService, private array $cache = [])
    {
    }

    /**
     * @inheritDoc
     */
    public function refreshUser(UserInterface $user): UserInterface|DesksheetUserInterface|null
    {
        if (!$user instanceof DesksheetUserInterface) {
            throw new UnsupportedUserException(
                sprintf('User must implement "%s", instance of "%s" given', DesksheetUserInterface::class, get_class($user))
            );
        }

        if (null === $reloadedUser = $this->userService->findById($user->getId())) {
            throw new UserNotFoundException(
                sprintf('User with ID "%d" could not be refreshed.', $user->getId())
            );
        }

        return $reloadedUser;
    }

    /**
     * @inheritDoc
     */
    public function loadUserByUsername(string $username): UserInterface
    {
        return $this->loadUserByIdentifier($username);
    }

    /**
     * @inheritDoc
     */
    public function loadUserByIdentifier(string $identifier): UserInterface
    {
        if (isset($this->cache[$identifier])) {
            return $this->cache[$identifier];
        }

        $user = $this->userService->findByUsername($identifier);

        if (null === $user) {
            throw new UserNotFoundException(
                sprintf('Identifier "%s" does not exist.', $identifier)
            );
        }

        return $this->cache[$identifier] = $user;
    }

    /**
     * @inheritDoc
     */
    public function supportsClass(string $class): bool
    {
        return is_subclass_of($class, DesksheetUserInterface::class);
    }
}

