<?php /** @noinspection ALL */
/** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types=1);

namespace Tests\Unit;

use App\Exceptions\ViewNotFoundException;
use App\Responses\ViewResponse;
use PHPUnit\Framework\TestCase;

class ViewResponseTest extends TestCase
{
    public string $content;
    public ViewResponse $view;
    public string $name;
    public const VIEW_PATH = __DIR__ . "/../../views/";

    public function setUp(): void
    {
        $this->content = '<h1>Hello World</h1>';
        $this->name = 'test';
        file_put_contents(self::VIEW_PATH . $this->name . '.php', $this->content);
        $this->view = ViewResponse::make($this->name);
    }

    public function tearDown(): void
    {
        if (file_exists($this->name)) {
            unlink($this->name);
        }
    }

    /**
     * @test
     * @return void
     */
    public function it_makes_a_view_file(): void
    {
        $this->assertInstanceOf(ViewResponse::class, $this->view);
    }

    /**
     * @test
     * @return void
     */
    public function it_renders_a_view_file(): void
    {
        $this->assertEquals($this->content, $this->view->render());
    }

    /**
     * @test
     * @throws ViewNotFoundException
     * @return void
     */
    public function it_throws_view_not_found_exception(): void
    {
        $this->expectException(ViewNotFoundException::class);
        ViewResponse::make('not-found')->render();
    }
}