<?php
/*
 * This file is part of the Desksheet project.
 *
 * (c) Mohamed Radhi GUENNICHI <hello@guennichi.com> (https://www.guennichi.com)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Desksheet\System\Factory;

use Desksheet\System\Model\ResourceInterface;

class ResourceFactory implements ResourceFactoryInterface
{
    private string $className;

    public function __construct(string $className)
    {
        $this->className = $className;
    }

    /**
     * @inheritDoc
     */
    public function createNew(): ResourceInterface
    {
        return new $this->className();
    }
}
