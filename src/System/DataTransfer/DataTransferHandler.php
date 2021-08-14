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

class DataTransferHandler implements DataTransferHandlerInterface
{
    /**
     * @param DataTransferorInterface[] $transformers
     */
    public function __construct(private iterable $transformers)
    {
    }

    /**
     * @inheritDoc
     */
    public function transfer($source, &$target): void
    {
        foreach ($this->transformers as $transformer) {
            if ($transformer->supports($source, $target)) {
                $this->apply($transformer, $source, $target);
            }
        }
    }

    protected function apply(DataTransferorInterface $transformer, $source, &$target): void
    {
        if ($transformer instanceof ObjectDataTransferor) {
            if (get_class($target) === $transformer::getSupportedClasses()[0]) {
                $transformer->reverseTransfer($source, $target);
                return;
            }
        }

        $transformer->transfer($source, $target);
    }
}
