<?php
/*
 * This file is part of the Desksheet project.
 *
 * (c) Mohamed Radhi GUENNICHI <hello@guennichi.com> (https://www.guennichi.com)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Desksheet\System\DependencyInjection\Compiler;

use Desksheet\System\Factory\ResourceFactory;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

class ResourceServiceRegistryPass implements CompilerPassInterface
{
    /**
     * @inheritDoc
     */
    public function process(ContainerBuilder $container): void
    {
        foreach ($container->getParameter('desksheet.resources') as $alias => $attrs) {
            // Register resource repository as a service
            $container->getDefinition($attrs['repository'])
                ->setArguments([$attrs['model'], new Reference('doctrine.orm.entity_manager')]);

            // Register resource base factory as an internal service
            $baseFactory = new Definition(ResourceFactory::class, [$attrs['model']]);
            $container->setDefinition($baseFactoryId = "desksheet.resource.$alias.factory", $baseFactory);

            // Register resource main factory as a service
            $container->getDefinition($attrs['factory'])
                ->setArguments([new Reference($baseFactoryId)]);
        }
    }
}
