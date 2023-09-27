<?php
declare(strict_types=1);

namespace App;

use App\Attributes\Route;
use App\Exceptions\RouteNotFoundException;
use Illuminate\Container\Container;
use ReflectionClass;
use ReflectionAttribute;

class Router {
    public function __construct(
        protected Container $container
    ){}
    public function registerRoutesThroughAttributes(array $controllers) {
        foreach($controllers as $controller) {
            $controllerReflector = new ReflectionClass($controller);
            $methods = $controllerReflector->getMethods();
            foreach($methods as $method){
                $attributes = $method->getAttributes(Route::class, ReflectionAttribute::IS_INSTANCEOF);
                foreach($attributes as $attribute) {
                    $route = $attribute->newInstance();
                    $this->register($route->routeMethod ,$route->routePath, [
                        $controller,
                        $method->getName()
                    ]);
                    // echo $route->routeMethod.' '.$route->routePath.' '.$controller. ' ' . $method->getName() . "<br>";
                }
            }
        }
    }
    public array $routes = [];
    public function register(string $method, string $path, callable|array $action) {
        $this->routes[$method][$path] = $action;
    }
    public function get(string $path, callable|array $action) {
        $this->register('GET', $path, $action);
    }
    public function post(string $path, callable|array $action) {
        $this->register('POST', $path, $action);
    }
    public function put(string $path, callable|array $action) {
        $this->register('PUT', $path, $action);
    }
    public function patch(string $path, callable|array $action) {
        $this->register('PATCH', $path, $action);
    }
    public function delete(string $path, callable|array $action) {
        $this->register('DELETE', $path, $action);
    }
    public function resolve(string $method, string $uri) {
        $path = explode('?', $uri)[0];
        $query = explode('?', $uri)[1] ?? '';
        $action = $this->routes[$method][$path] ?? null;
        
        if(!isset($action)) {
            throw new RouteNotFoundException($method, $path);
        }
        if(is_callable($action)) {
            return $action();
        }
        if(is_array($action) && count($action) === 2) {
            $controller = $action[0];
            $method = $action[1];

            if(class_exists($controller) && method_exists($controller, $method)){
                $instance = $this->container->get($controller);
                return call_user_func_array([$instance, $method], []);
            }
        }
        throw new RouteNotFoundException($method, $path);
    }
}
?>