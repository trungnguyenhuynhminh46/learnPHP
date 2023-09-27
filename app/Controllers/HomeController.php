<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Attributes\Route;
use App\Attributes\Get;
use App\Attributes\Post;
use App\Attributes\Put;
use App\Attributes\Delete;
use App\Enums\HttpMethod;
use App\View;

class HomeController {
    public function __construct(){}

    #[Get('/')]
    public function index() {
        return View::make('index');
    }

    #[Route('/normal', "GET")]
    public function normal() {
        return 'normal';
    }

    #[Get('/get')]
    public function get() {
        return 'get';
    }

    #[Post('/post')]
    public function post() {
        return 'post';
    }

    #[Put('/put')]
    public function put() {
        return 'put';
    }

    #[Delete('/delete')]
    public function delete() {
        return 'delete';
    }
}
?>