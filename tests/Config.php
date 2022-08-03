<?php /** @noinspection ALL */

namespace Tests;

trait Config
{
    public function getConfigMock()
    {
        $configMock = $this->createMock(\App\Config\Config::class);
        $configMock->method('db')->willReturn($this->getDbInfo());
        return $configMock;
    }

    /**
     * @return array
     */
    public function getDbInfo(): array
    {
        return [
            'driver'   => $_ENV['DATABASE_DRIVER'],
            'host'     => $_ENV['DATABASE_HOST'],
            'port'     => $_ENV['DATABASE_PORT'],
            'database' => $_ENV['DATABASE_DATABASE'],
            'username' => $_ENV['DATABASE_USERNAME'],
            'password' => $_ENV['DATABASE_PASSWORD'],
        ];
    }
}