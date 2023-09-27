<?php
declare(strict_types=1);

namespace App\Exceptions;

class RouteNotFoundException extends \Exception {
    public function __construct(string $method, string $path) {
        parent::__construct("Route $method $path not found", 404);
    }
}
?>