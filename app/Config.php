<?php
declare(strict_types=1);

namespace App;

class Config {
    private array $config = [];
    public function __construct(array $env) {
        $this->config = [
            'db' => [
                'driver' => $env['DB_DRIVER'] ?? 'mysql',
                'host' => $env['DB_HOST'],
                'database' => $env['DB_DATABASE'],
                'username' => $env['DB_USERNAME'],
                'password' => $env['DB_PASSWORD'],
                'charset' => 'utf8',
                'collation' => 'utf8_unicode_ci',
                'prefix' => '',
            ],
            'mailer' => [
                'dsn' => $env['MAILER_DSN'],
            ],
        ];
    }

    public function __get(string $name) {
        return $this->config[$name];
    }
}
?>