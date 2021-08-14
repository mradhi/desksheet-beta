<?php
/*
 * This file is part of the Desksheet project.
 *
 * (c) Mohamed Radhi GUENNICHI <hello@guennichi.com> (https://www.guennichi.com)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Desksheet\Module\User\EventSubscriber;

use DateTime;
use Desksheet\Module\User\Model\UserInterface;
use Desksheet\Module\User\Service\UserService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Http\Event\LoginSuccessEvent;
use Webmozart\Assert\Assert;

class LoginSuccessSubscriber implements EventSubscriberInterface
{
    public function __construct(private UserService $userService)
    {
    }

    public function onLoginSuccess(LoginSuccessEvent $event): void
    {
        /** @var UserInterface $user */
        $user = $event->getUser();

        Assert::isInstanceOf($user, UserInterface::class);

        $user->setLastLogin(new DateTime());

        $this->userService->update($user);
    }

    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents(): array
    {
        return [
            LoginSuccessEvent::class => 'onLoginSuccess'
        ];
    }
}
