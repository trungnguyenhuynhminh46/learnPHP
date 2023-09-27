<?php
declare(strict_types=1);

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Router;
use App\Exceptions\RouteNotFoundException;

class RouterTest extends TestCase {
    private Router $router;

    protected function setUp(): void {
        parent::setUp();
        $this->router = new Router();
    }

    /** @test */
    public function it_registers_a_route(): void {
        // When we call a register method
        $this->router->register('GET', '/users', ['Users', 'index']);

        $expected = [
            'GET' => [
                '/users' => ['Users', 'index']
            ]
        ];

        // The we assert route was registered
        $this->assertEquals($expected, $this->router->routes);
    }

    /** @test */
    public function it_registers_a_get_route(): void {
        $this->router->get('/users', function() {
            return 'Hello World';
        });

        $expected = [
            'GET' => [
                '/users' => function() {
                    return 'Hello World';
                }
            ]
        ];

        $this->assertEquals($expected, $this->router->routes);
    }

    /** @test */
    public function it_registers_a_post_route(): void {
        $this->router->post('/users', function() {
            return 'Hello World';
        });

        $expected = [
            'POST' => [
                '/users' => function() {
                    return 'Hello World';
                }
            ]
        ];

        $this->assertEquals($expected, $this->router->routes);
    }

    /** @test */
    public function it_registers_a_put_route(): void {
        $this->router->put('/users', function() {
            return 'Hello World';
        });

        $expected = [
            'PUT' => [
                '/users' => function() {
                    return 'Hello World';
                }
            ]
        ];

        $this->assertEquals($expected, $this->router->routes);
    }

    /** @test */
    public function it_registers_a_patch_route(): void {
        $this->router->patch('/users', function() {
            return 'Hello World';
        });

        $expected = [
            'PATCH' => [
                '/users' => function() {
                    return 'Hello World';
                }
            ]
        ];

        $this->assertEquals($expected, $this->router->routes);
    }

    /** @test */
    public function it_registers_a_delete_route(): void {
        $this->router->delete('/users', function() {
            return 'Hello World';
        });

        $expected = [
            'DELETE' => [
                '/users' => function() {
                    return 'Hello World';
                }
            ]
        ];

        $this->assertEquals($expected, $this->router->routes);
    }

    public function there_are_no_routes_at_beginning(): void {
        $this->assertEmpty($this->router->routes);
    }

    /** 
     * @test 
     * @dataProvider it_throws_route_not_found_exception_data_provider 
     * */
    public function it_throws_route_not_found_exception(
        string $requestUri,
        string $requestMethod
    ): void {
        $user = new class() {
            public function index() {
                return 'Hello World';
            }
        };
        $this->router->post('/users', [$user::class, 'index']);
        $this->router->get('/users', ['Users', 'index']);

        $this->expectException(RouteNotFoundException::class);
        $this->router->resolve($requestMethod, $requestUri);
    }

    public function it_throws_route_not_found_exception_data_provider(): array {
        return [
            ['/users', 'GET'],
            ['/users', 'PUT'],
            ['/users', 'PATCH'],
            ['/invoices', 'DELETE'],
        ];
    }

    /** 
     * @test 
     * dataProvider Tests\DataProvider\RouterDataProvider::it_resolve_route_from_closure_data_provider
     * */
    public function it_resolve_route_from_closure(
        $returnValue = "helloe"
    ): void {
        $this->router->get('/users', function() use($returnValue) {
            return $returnValue;
        });
        $this->assertSame($returnValue, $this->router->resolve('GET', '/users'));
    }
}
?>