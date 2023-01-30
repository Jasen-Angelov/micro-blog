<?php

namespace Middleware;

use App\Middleware\UserAuthentication;
use FastRoute\Route;
use PHPUnit\Framework\TestCase;
use Slim\Http\Request;
use Slim\Http\Response;

class UserAuthenticationTest extends TestCase
{
     public function test_if_user_is_not_authenticated_and_route_is_not_allowed_then_redirect_to_login()
    {
        $response = $this->createMock(Response::class);
        $request = $this->createMock(Request::class);
        $route_builder = $this->getMockBuilder(Route::class);
        $route_builder->disableOriginalConstructor();
        $route_builder->setMethods(['getName']);
        $route = $route_builder->getMock();
        $route->expects($this->exactly(1))
            ->method('getName')
            ->willReturn('home');
        $request->expects($this->exactly(1))
            ->method('getAttribute')
            ->with('route')
            ->willReturn($route);
        $response->expects($this->exactly(1))
            ->method('withRedirect')
            ->with('/login')
            ->willReturn($response);
        $next = function ($req, $res) {
            $this->fail('Next middleware should not be called!');
        };
        $middleware = new UserAuthentication();
        $middleware($request, $response, $next);
    }
}
