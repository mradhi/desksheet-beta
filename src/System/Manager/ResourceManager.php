<?php
/*
 * This file is part of the Desksheet project.
 *
 * (c) Mohamed Radhi GUENNICHI <hello@guennichi.com> (https://www.guennichi.com)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Desksheet\System\Manager;

use Desksheet\System\Aware\EntityManagerAware;
use Desksheet\System\Model\ResourceInterface;

class ResourceManager implements ResourceManagerInterface
{
    use EntityManagerAware;

    public function importAndFlush(ResourceInterface $resource): void
    {
        $this->import($resource);
        $this->entityManager->flush();
    }

    public function deleteAndFlush(ResourceInterface $resource): void
    {
        $this->entityManager->remove($resource);
        $this->entityManager->flush();
    }

    public function import(ResourceInterface $resource): void
    {
        // Persist if it's a new resource
        if (null === $resource->getId()) {
            $this->entityManager->persist($resource);
        }
    }

    public function delete(ResourceInterface $resource): void
    {
        $this->entityManager->remove($resource);
    }

    public function flush(): void
    {
        $this->entityManager->flush();
    }
}
