<?php
/*
 * This file is part of the Desksheet project.
 *
 * (c) Mohamed Radhi GUENNICHI <hello@guennichi.com> (https://www.guennichi.com)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Desksheet\Module\Expense\Model;

use Desksheet\Module\User\Model\UserAwareInterface;
use Desksheet\System\Model\ResourceInterface;
use Desksheet\System\Model\TimestampableInterface;
use Stringable;

interface AccountInterface extends ResourceInterface, UserAwareInterface, TimestampableInterface, Stringable
{
    public function getCurrency(): ?string;
}
