<?php
/*
 * This file is part of the Desksheet project.
 *
 * (c) Mohamed Radhi GUENNICHI <hello@guennichi.com> (https://www.guennichi.com)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Desksheet\Module\User\Factory;

use Desksheet\Module\User\Model\UserInterface;
use Desksheet\System\Factory\ResourceFactoryInterface;
use Desksheet\System\Model\ResourceInterface;

class UserFactory implements ResourceFactoryInterface
{
    public function __construct(private ResourceFactoryInterface $innerFactory)
    {
    }

    /**
     * @inheritDoc
     *
     * @return ResourceInterface|UserInterface
     */
    public function createNew(): ResourceInterface
    {
        return $this->innerFactory->createNew();
    }
}
