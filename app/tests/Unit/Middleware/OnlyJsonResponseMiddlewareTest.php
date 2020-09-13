<?php

namespace Tests\Unit\Middleware;

use Tests\TestCase;
use Illuminate\Http\Request;
use Illuminate\Foundation\Testing\WithFaker;
use App\Http\Middleware\OnlyJsonResponseMiddleware;
use App\Exceptions\HttpException\InvalidAcceptHeaderException;

class OnlyJsonResponseMiddlewareTest extends TestCase
{
    use WithFaker;

    /**
     * @group unit
     * @group middleware
     */
    public function testFail()
    {
        $this->expectException(InvalidAcceptHeaderException::class);

        $request = new Request([], [], [], [], [], [
            'REQUEST_URI' => 'test/unit/' . $this->faker->name,
            'HTTP_ACCEPT' => $this->faker->randomElement([
                'text/html',
                'application/xml',
                'application/pdf'
            ])
        ]);

        (new OnlyJsonResponseMiddleware())->handle($request, null);
    }

    /**
     * @group unit
     * @group middleware
     */
    public function testSuccess()
    {
        $request = new Request([], [], [], [], [], [
            'REQUEST_URI' => 'test/unit/' . $this->faker->name,
            'HTTP_ACCEPT' => $this->faker->randomElement(['*/*', 'application/json', null])
        ]);

        (new OnlyJsonResponseMiddleware())->handle($request, function () {
            $this->assertTrue(true);
        });
    }
}
