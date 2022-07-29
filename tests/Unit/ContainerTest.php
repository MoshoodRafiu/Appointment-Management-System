<?php /** @noinspection ALL */

namespace Tests\Unit;

use App\Container;
use App\Exceptions\Container\ContainerException;
use App\Exceptions\Container\InvalidClassException;
use App\Exceptions\Container\NotFoundException;
use PHPUnit\Framework\TestCase;
use ReflectionException;

class ContainerTest extends TestCase
{
    private Container $container;

    public function setUp(): void
    {
        $this->container = new Container();
    }

    /**
     * @test
     */
    public function it_sets_a_class(): void
    {
        $class = new class {};
        $this->container->set($class::class, fn() => $class);
        $expected = [
            $class::class => fn() => $class
        ];
        $this->assertEquals($expected, $this->container->getEntries());
    }

    /**
     * @test
     */
    public function it_gets_a_class(): void
    {
        $class = new class {};
        $this->container->set($class::class, fn() => $class);
        $this->assertEquals($class, $this->container->get($class::class));
    }

    /**
     * @test
     */
    public function it_has_a_class(): void
    {
        $class = new class {};
        $this->container->set($class::class, fn() => $class);
        $this->assertTrue($this->container->has($class::class));
    }

    /**
     * @test
     */
    public function it_resolves_a_class(): void
    {
        $class = new class {
            public function __construct()
            {
            }
        };
        $this->assertEquals($class, $this->container->get($class::class));
    }
}