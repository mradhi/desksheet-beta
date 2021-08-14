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

interface DataTransferorInterface
{
    /**
     * @param $source
     * @param $target
     */
    public function transfer($source, &$target): void;

    /**
     * @param $source
     * @param $target
     *
     * @return bool
     */
    public function supports($source, $target): bool;
}
