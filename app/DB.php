<?php
declare(strict_types=1);

namespace App;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;

class DB {
    private Connection $conn;

    public function __construct(array $config) {
        $connectionParams = [
            'dbname' => $config['database'],
            'user' => $config['username'],
            'password' => $config['password'],
            'host' => $config['host'],
            'driver' => $config['driver'] ?? 'pdo_mysql',
        ];
        
        $this->conn = DriverManager::getConnection($connectionParams);
    }

    public function __call(string $name, array $arguments = []) {
        return call_user_func_array([$this->conn, $name], $arguments);
    }
}
?>