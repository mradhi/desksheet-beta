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

interface DataTransferHandlerInterface
{
    /**
     * @param $source
     * @param $target
     */
    public function transfer($source, &$target): void;
}
