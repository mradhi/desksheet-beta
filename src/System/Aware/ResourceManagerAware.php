<?php
/*
 * This file is part of the Desksheet project.
 *
 * (c) Mohamed Radhi GUENNICHI <hello@guennichi.com> (https://www.guennichi.com)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Desksheet\System\Aware;

use Desksheet\System\Manager\ResourceManagerInterface;
use Symfony\Contracts\Service\Attribute\Required;

trait ResourceManagerAware
{
    protected ResourceManagerInterface $resourceManager;

    #[Required]
    public function setResourceManager(ResourceManagerInterface $resourceManager): void
    {
        $this->resourceManager = $resourceManager;
    }
}
