<?php
/*
 * This file is part of the Desksheet project.
 *
 * (c) Mohamed Radhi GUENNICHI <hello@guennichi.com> (https://www.guennichi.com)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Desksheet\System\DataTransfer;

use Webmozart\Assert\Assert;

abstract class ObjectDataTransferor implements DataTransferorInterface
{
    /**
     * @return string[] Should return an array of 2 classnames
     *                  The type one is the source in the transform() method
     *                  The type two is the source in the reverseTransform() method.
     */
    abstract public static function getSupportedClasses(): array;

    /**
     * @param $source
     * @param $target
     */
    abstract public function reverseTransfer($source, $target): void;

    /**
     * @inheritDoc
     */
    public function supports($source, $target): bool
    {
        if (!is_object($source) && !is_object($target)) {
            return false;
        }

        Assert::count(static::getSupportedClasses(), 2);
        Assert::notEq($sourceClass = get_class($source), $targetClass = get_class($target));

        return $sourceClass !== $targetClass &&
            in_array($sourceClass, static::getSupportedClasses()) &&
            in_array($targetClass, static::getSupportedClasses());
    }
}
