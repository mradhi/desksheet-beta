<?php
/*
 * This file is part of the Desksheet project.
 *
 * (c) Mohamed Radhi GUENNICHI <hello@guennichi.com> (https://www.guennichi.com)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Desksheet\System\Attribute;

use Attribute;

#[Attribute]
final class Resource
{
    public function __construct(
        public ?string $repository = null,
        public ?string $factory = null
    )
    {
    }
}
