<?php
declare(strict_types=1);

namespace App;

class Config {
    private array $config = [];
    public function __construct(array $env) {
        $this->config = [
            'db' => [
                'host' => $env['DB_HOST'],
                'user' => $env['DB_USERNAME'],
                'password' => $env['DB_PASSWORD'],
                'driver' => $env['DB_DRIVER'] ?? 'pdo_mysql',
                'dbname' => $env['DB_DATABASE']
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