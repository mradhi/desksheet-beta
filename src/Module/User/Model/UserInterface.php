<?php
/*
 * This file is part of the Desksheet project.
 *
 * (c) Mohamed Radhi GUENNICHI <hello@guennichi.com> (https://www.guennichi.com)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Desksheet\Module\User\Model;

use DateTimeInterface;
use Desksheet\System\Model\ResourceInterface;
use Desksheet\System\Model\TimestampableInterface;
use Serializable;
use Stringable;
use Symfony\Component\Security\Core\User\UserInterface as BaseUserInterface;

interface UserInterface extends ResourceInterface, BaseUserInterface, TimestampableInterface, Stringable, Serializable
{
    public function setUsername(string $username): void;

    public function setPassword(?string $password): void;

    public function getPlainPassword(): ?string;

    public function setPlainPassword(string $plainPassword): void;

    /**
     * Never use this to check if this user has access to anything!
     * Use the SecurityContext, or an implementation of AccessDecisionManager
     * instead, e.g.
     *         $securityContext->isGranted('ROLE_USER');
     *
     * @param string $role
     *
     * @return bool
     */
    public function hasRole(string $role): bool;

    public function addRole(string $role): void;

    public function removeRole(string $role): void;

    public function getLastLogin(): ?DateTimeInterface;

    public function setLastLogin(?DateTimeInterface $lastLogin): void;
}
