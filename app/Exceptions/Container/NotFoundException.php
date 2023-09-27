<?php
declare(strict_types=1);

namespace App\Exceptions\Container;

class NotFoundException extends \Exception implements \Psr\Container\NotFoundExceptionInterface {}