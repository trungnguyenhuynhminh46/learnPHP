<?php
declare(strict_types=1);

namespace Tests\DataProvider;

class RouterDataProvider {
    public static function it_throws_route_not_found_exception_data_provider(): array {
        return [
            [123],
            [1,2,3],
            ['string'],
            [true],
        ];
    }
}
?>