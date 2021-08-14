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

use Desksheet\System\Attribute\Resource;
use Desksheet\System\Factory\ResourceFactoryInterface;
use Desksheet\System\Repository\ResourceRepositoryInterface;
use Generator;
use ReflectionClass;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Finder\Finder;
use Webmozart\Assert\Assert;
use function Symfony\Component\String\u;

class ResourceMetadataRegistryPass implements CompilerPassInterface
{
    /**
     * @inheritDoc
     */
    public function process(ContainerBuilder $container): void
    {
        $resources = [];

        /**
         * @var string $alias
         * @var string $classname
         * @var Resource $attribute
         */
        foreach ($this->getResources($container) as [$alias, $classname, $attribute]) {
            Assert::subclassOf($attribute->repository, ResourceRepositoryInterface::class);
            Assert::subclassOf($attribute->factory, ResourceFactoryInterface::class);

            $resources[$alias] = [
                'model'      => $classname,
                'repository' => $attribute->repository,
                'factory'    => $attribute->factory
            ];
        }

        $container->setParameter('desksheet.resources', $resources);
    }

    private function getResources(ContainerBuilder $container): Generator
    {
        $projectDir = $container->getParameter('kernel.project_dir');
        $finder = Finder::create()
            ->files()
            ->in($projectDir . '/src/Module/[!Resource]*/Model')
            //->path('Model')
            ->name('*.php')
            ->notName('*Interface.php');

        foreach ($finder as $file) {
            $classname = u($file->getRealPath())
                ->replace($projectDir . '/src', 'Desksheet')
                ->replace('/', '\\')
                ->replace('.php', '')
                ->toString();

            $reflectionClass = new ReflectionClass($classname);
            if ($reflectionClass->isInterface() || $reflectionClass->isAbstract() || !$reflectionClass->isInstantiable()) {
                // ignore
                continue;
            }

            $attributes = $reflectionClass->getAttributes(Resource::class);
            if (false !== $attribute = reset($attributes)) {
                /** @var Resource $metadata */
                $metadata = $attribute->newInstance();
                $alias = u($classname)
                    ->after('Module\\')
                    ->snake()
                    ->toString();

                yield [$alias, $classname, $metadata];
            }
        }
    }
}
