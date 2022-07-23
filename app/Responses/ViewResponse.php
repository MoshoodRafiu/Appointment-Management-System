<?php /** @noinspection ALL */

declare(strict_types=1);

namespace App\Responses;

use App\Exceptions\ViewNotFoundException;

class ViewResponse
{
    protected const VIEW_PATH = __DIR__ . "/../../views/";

    public function __construct(protected string $view, protected array $args = [])
    {
    }

    /**
     * @param string $view
     * @param array $args
     * @return static
     */
    public static function make(string $view, array $args = []): static
    {
        return new static($view, $args);
    }

    /**
     * @return string
     * @throws ViewNotFoundException
     */
    public function render(): string
    {
        $path = self::VIEW_PATH . $this->view . '.php';
        if (!file_exists($path)) {
            throw new ViewNotFoundException();
        }
        ob_start();
        include $path;
        return ob_get_clean();
    }

    public function __toString(): string
    {
        return $this->render();
    }
}