<?php

namespace Middleware;

use App\Middleware\LoginValidator;
use PHPUnit\Framework\TestCase;
use Slim\Http\Request;
use Slim\Http\Response;

class LoginValidatorTest extends TestCase
{
    public function test_if_validate_post_method_returns_true_when_all_parameters_are_valid()
    {
        $response = $this->createMock(Response::class);
        $request = $this->createMock(Request::class);
        $request->expects($this->exactly(1))
            ->method('getAttribute')
            ->with('validation_success', null)
            ->willReturn(true);
        $request->expects($this->exactly(1))
            ->method('getParsedBody')
            ->willReturn(['email' => 'jasen@abv.bg', 'password' => '123456']);
        $request->expects($this->once())
            ->method('getMethod')
            ->willReturn('POST');
        //This is the method that tell us if the request is valid or not
        $request->expects($this->atLeast(2))
            ->method('withAttribute')
            ->withConsecutive(['validation_errors', []], ['validation_success', true])
            ->willReturnOnConsecutiveCalls($request, $request);
        $validator = new LoginValidator();
        $validator($request, $response , function ($req, $res) {
            $this->assertTrue($req->getAttribute('validation_success'));
        });
    }

    public function test_if_validate_post_method_returns_false_when_email_is_missing()
    {
        $response = $this->createMock(Response::class);
        $request = $this->createMock(Request::class);
        $request->expects($this->exactly(1))
            ->method('getAttribute')
            ->with('validation_success', null)
            ->willReturn(false);
        $request->expects($this->exactly(1))
            ->method('getParsedBody')
            ->willReturn(['password' => '123456']);
        $request->expects($this->once())
            ->method('getMethod')
            ->willReturn('POST');
        //This is the method that tell us if the request is valid or not
        $request->expects($this->atLeast(2))
            ->method('withAttribute')
            ->withConsecutive(['validation_errors', ['Missing required parameters!']], ['validation_success', false])
            ->willReturnOnConsecutiveCalls($request, $request);
        $validator = new LoginValidator();
        $validator($request, $response , function ($req, $res) {
            $this->assertFalse($req->getAttribute('validation_success'));
        });
    }

    public function test_if_validate_post_method_returns_false_when_password_is_missing()
    {
        $response = $this->createMock(Response::class);
        $request = $this->createMock(Request::class);
        $request->expects($this->exactly(1))
            ->method('getAttribute')
            ->with('validation_success', null)
            ->willReturn(false);
        $request->expects($this->exactly(1))
            ->method('getParsedBody')
            ->willReturn(['email' => 'jasen@abv.bg']);
        $request->expects($this->once())
            ->method('getMethod')
            ->willReturn('POST');
        //This is the method that tell us if the request is valid or not
        $request->expects($this->atLeast(2))
            ->method('withAttribute')
            ->withConsecutive(['validation_errors', ['Missing required parameters!']], ['validation_success', false])
            ->willReturnOnConsecutiveCalls($request, $request);
        $validator = new LoginValidator();
        $validator($request, $response , function ($req, $res) {
            $this->assertFalse($req->getAttribute('validation_success'));
        });
    }

    public function test_if_validate_post_method_returns_false_when_email_is_invalid()
    {
        $response = $this->createMock(Response::class);
        $request = $this->createMock(Request::class);
        $request->expects($this->exactly(1))
            ->method('getAttribute')
            ->with('validation_success', null)
            ->willReturn(false);
        $request->expects($this->exactly(1))
            ->method('getParsedBody')
            ->willReturn(['email' => 'jasen@abv', 'password' => '123456']);
        $request->expects($this->once())
            ->method('getMethod')
            ->willReturn('POST');
        //This is the method that tell us if the request is valid or not
        $request->expects($this->atLeast(2))
            ->method('withAttribute')
            ->withConsecutive(['validation_errors', ['Email input data is not a valid email!']], ['validation_success', false])
            ->willReturnOnConsecutiveCalls($request, $request);
        $validator = new LoginValidator();
        $validator($request, $response , function ($req, $res) {
            $this->assertFalse($req->getAttribute('validation_success'));
        });
    }
}
