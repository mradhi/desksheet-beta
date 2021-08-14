<?php
/*
 * This file is part of the Desksheet project.
 *
 * (c) Mohamed Radhi GUENNICHI <hello@guennichi.com> (https://www.guennichi.com)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Desksheet\Tests\Unit\System\DataTransfer;

use Desksheet\System\DataTransfer\DataTransferHandler;
use Desksheet\System\DataTransfer\DataTransferorInterface;
use Desksheet\System\DataTransfer\ObjectDataTransferor;
use PHPUnit\Framework\TestCase;

class DataTransferHandlerTest extends TestCase
{
    private ?DataTransferHandler $dataTransferHandler;

    protected function setUp(): void
    {
        $this->dataTransferHandler = new DataTransferHandler([
            new PlusTransferor(),
            new ObjectTransferor()
        ]);
    }

    public function testItTransferPrimitiveData(): void
    {
        $a = 5;
        $b = 3;

        $this->dataTransferHandler->transfer($a, $b);

        $this->assertSame(8, $b);
    }

    public function testItTransferObjectData(): void
    {
        $source = new \stdClass();
        $source->name = 'Radhi';

        $target = new Foo();

        $this->dataTransferHandler->transfer($source, $target);

        $this->assertSame('Radhi', $target->name);

        $this->dataTransferHandler->transfer($target, $source);

        $this->assertSame('Radhi_reversed', $source->name);
        $this->assertSame('Radhi', $target->name);
    }
}

class PlusTransferor implements DataTransferorInterface
{
    public function transfer($source, &$target): void
    {
        $target = $source + $target;
    }

    public function supports($source, $target): bool
    {
        return is_int($source);
    }
}

class ObjectTransferor extends ObjectDataTransferor
{
    public static function getSupportedClasses(): array
    {
        return [\stdClass::class, Foo::class];
    }

    public function transfer($source, &$target): void
    {
        $target->name = $source->name;
    }

    public function reverseTransfer($source, $target): void
    {
        $target->name = $source->name . '_reversed';
    }
}

class Foo {public string $name;}
