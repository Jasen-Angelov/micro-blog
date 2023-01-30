<?php

namespace Middleware;

use App\Middleware\BlogValidator;
use PHPUnit\Framework\TestCase;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\UploadedFile;
use Slim\Route;

class BlogValidatorTest extends TestCase
{
    public function test_if_get_request_be_correctly_validated_if_we_provide_valid_data_in_route()
    {
        $response = $this->createMock(Response::class);
        $request = $this->createMock(Request::class);
        $route = $this->createMock(Route::class);
        $route->expects($this->once())
            ->method('getArguments')
            ->willReturn(['id' => 1]);
        $request->expects($this->exactly(2))
            ->method('getAttribute')
            ->withConsecutive(['route'], ['validation_success', null])
            ->willReturnOnConsecutiveCalls($route, true);
        $request->expects($this->once())
            ->method('getMethod')
            ->willReturn('GET');
        //This is the method that tell us if the request is valid or not
        $request->expects($this->atLeast(2))
            ->method('withAttribute')
            ->withConsecutive(['validation_errors', []], ['validation_success', true])
            ->willReturnOnConsecutiveCalls($request, $request);
        $validator = new BlogValidator();
        $validator($request, $response , function ($req, $res) {
            $this->assertTrue($req->getAttribute('validation_success'));
        });
    }

    public function test_if_get_request_be_correctly_validated_if_we_provide_invalid_data_in_route()
    {
        $response = $this->createMock(Response::class);
        $request = $this->createMock(Request::class);
        $route = $this->createMock(Route::class);
        $route->expects($this->once())
            ->method('getArguments')
            ->willReturn(['id' => 'invalid']);
        $request->expects($this->exactly(2))
            ->method('getAttribute')
            ->withConsecutive(['route'], ['validation_success', false])
            ->willReturnOnConsecutiveCalls($route, false);
        $request->expects($this->once())
            ->method('getMethod')
            ->willReturn('GET');
        //This is the method that tell us if the request is valid or not
        $request->expects($this->atLeast(2))
            ->method('withAttribute')
            ->withConsecutive(['validation_errors', ['Id input data is not an integer!']], ['validation_success', false])
            ->willReturnOnConsecutiveCalls($request, $request);
        $validator = new BlogValidator();
        $validator($request, $response , function ($req, $res) {
            $this->assertFalse($req->getAttribute('validation_success'));
        });
    }

    public function test_if_get_request_be_correctly_validated_if_we_provide_valid_slug_data_in_route()
    {
        $response = $this->createMock(Response::class);
        $request = $this->createMock(Request::class);
        $route = $this->createMock(Route::class);
        $route->expects($this->once())
            ->method('getArguments')
            ->willReturn(['slug' => 'test-slug']);
        $request->expects($this->exactly(2))
            ->method('getAttribute')
            ->withConsecutive(['route'], ['validation_success', null])
            ->willReturnOnConsecutiveCalls($route, true);
        $request->expects($this->once())
            ->method('getMethod')
            ->willReturn('GET');
        //This is the method that tell us if the request is valid or not
        $request->expects($this->atLeast(2))
            ->method('withAttribute')
            ->withConsecutive(['validation_errors', []], ['validation_success', true])
            ->willReturnOnConsecutiveCalls($request, $request);
        $validator = new BlogValidator();
        $validator($request, $response , function ($req, $res) {
            $this->assertTrue($req->getAttribute('validation_success'));
        });
    }

    public function test_if_get_request_be_correctly_validated_if_we_provide_invalid_slug_data_in_route()
    {
        $response = $this->createMock(Response::class);
        $request = $this->createMock(Request::class);
        $route = $this->createMock(Route::class);
        $route->expects($this->once())
            ->method('getArguments')
            ->willReturn(['slug' => 'null@']);
        $request->expects($this->exactly(2))
            ->method('getAttribute')
            ->withConsecutive(['route'], ['validation_success', false])
            ->willReturnOnConsecutiveCalls($route, false);
        $request->expects($this->once())
            ->method('getMethod')
            ->willReturn('GET');
        //This is the method that tell us if the request is valid or not
        $request->expects($this->atLeast(2))
            ->method('withAttribute')
            ->withConsecutive(['validation_errors', ['Slug input data, is not valid pattern: slug']], ['validation_success', false])
            ->willReturnOnConsecutiveCalls($request, $request);
        $validator = new BlogValidator();
        $validator($request, $response , function ($req, $res) {
            $this->assertFalse($req->getAttribute('validation_success'));
        });
    }

    public function test_if_post_request_be_correctly_validated_if_we_provide_valid_data_in_body_and_valid_file()
    {
        $response = $this->createMock(Response::class);
        $request = $this->createMock(Request::class);
        $file = $this->createMock(UploadedFile::class);
        $file->expects($this->atLeastOnce())
            ->method('getError')
            ->willReturn(UPLOAD_ERR_OK);
        $file->expects($this->once())
            ->method('getClientMediaType')
            ->willReturn('image/png');
        $request->expects($this->exactly(1))
            ->method('getAttribute')
            ->with('validation_success', null)
            ->willReturn(true);
        $request->expects($this->exactly(1))
            ->method('getParams')
            ->willReturn(['title' => 'test', 'content' => 'test content']);
        $request->expects($this->exactly(1))
            ->method('getUploadedFiles')
            ->willReturn(['blog_image' => $file]);
        $request->expects($this->once())
            ->method('getMethod')
            ->willReturn('POST');
        //This is the method that tell us if the request is valid or not
        $request->expects($this->atLeast(2))
            ->method('withAttribute')
            ->withConsecutive(['validation_errors', []], ['validation_success', true])
            ->willReturnOnConsecutiveCalls($request, $request);
        $validator = new BlogValidator();
        $validator($request, $response , function ($req, $res) {
            $this->assertTrue($req->getAttribute('validation_success'));
        });
    }

    public function test_if_post_request_be_correctly_validated_if_we_provide_invalid_data_in_body_and_valid_file()
    {
        $response = $this->createMock(Response::class);
        $request = $this->createMock(Request::class);
        $file = $this->createMock(UploadedFile::class);
        $file->expects($this->atLeastOnce())
            ->method('getError')
            ->willReturn(UPLOAD_ERR_OK);
        $file->expects($this->once())
            ->method('getClientMediaType')
            ->willReturn('image/png');
        $request->expects($this->exactly(1))
            ->method('getAttribute')
            ->with('validation_success', null)
            ->willReturn(false);
        $request->expects($this->exactly(1))
            ->method('getParams')
            ->willReturn(['title' => 'test', 'content' => 'test content', 'slug' => 'test-slug']);
        $request->expects($this->exactly(1))
            ->method('getUploadedFiles')
            ->willReturn(['blog_image' => $file]);
        $request->expects($this->once())
            ->method('getMethod')
            ->willReturn('POST');
        //This is the method that tell us if the request is valid or not
        $request->expects($this->atLeast(2))
            ->method('withAttribute')
            ->withConsecutive(['validation_errors', ['Unhandled POST parameter with name: slug']], ['validation_success', false])
            ->willReturnOnConsecutiveCalls($request, $request);
        $validator = new BlogValidator();
        $validator($request, $response , function ($req, $res) {
            $this->assertFalse($req->getAttribute('validation_success'));
        });
    }

    public function test_if_post_request_be_correctly_validated_if_we_provide_valid_data_in_body_and_invalid_file()
    {
        $response = $this->createMock(Response::class);
        $request = $this->createMock(Request::class);
        $file = $this->createMock(UploadedFile::class);
        $file->expects($this->atLeastOnce())
            ->method('getError')
            ->willReturn(UPLOAD_ERR_NO_FILE);
        $request->expects($this->exactly(1))
            ->method('getAttribute')
            ->with('validation_success', null)
            ->willReturn(false);
        $request->expects($this->exactly(1))
            ->method('getParams')
            ->willReturn(['title' => 'test', 'content' => 'test content']);
        $request->expects($this->exactly(1))
            ->method('getUploadedFiles')
            ->willReturn(['blog_image' => $file]);
        $request->expects($this->once())
            ->method('getMethod')
            ->willReturn('POST');
        //This is the method that tell us if the request is valid or not
        $request->expects($this->atLeast(2))
            ->method('withAttribute')
            ->withConsecutive(['validation_errors', ['Image is required!']], ['validation_success', false])
            ->willReturnOnConsecutiveCalls($request, $request);
        $validator = new BlogValidator();
        $validator($request, $response , function ($req, $res) {
            $this->assertFalse($req->getAttribute('validation_success'));
        });
    }

    public function test_if_put_request_be_correctly_validated_if_we_provide_valid_data_in_body_and_valid_file()
    {
        $response = $this->createMock(Response::class);
        $request = $this->createMock(Request::class);
        $file = $this->createMock(UploadedFile::class);
        $route = $this->createMock(Route::class);
        $route->expects($this->once())
            ->method('getArguments')
            ->willReturn(['id' => 1]);
        $file->expects($this->atLeastOnce())
            ->method('getError')
            ->willReturn(UPLOAD_ERR_OK);
        $file->expects($this->once())
            ->method('getClientMediaType')
            ->willReturn('image/png');
        $request->expects($this->exactly(2))
            ->method('getAttribute')
            ->withConsecutive(['route'], ['validation_success', null])
            ->willReturnOnConsecutiveCalls($route, true);
        $request->expects($this->exactly(1))
            ->method('getParams')
            ->willReturn(['title' => 'test', 'content' => 'test content', '_METHOD' => 'PUT']);
        $request->expects($this->exactly(1))
            ->method('getUploadedFiles')
            ->willReturn(['blog_image' => $file]);
        $request->expects($this->once())
            ->method('getMethod')
            ->willReturn('PUT');
        //This is the method that tell us if the request is valid or not
        $request->expects($this->atLeast(2))
            ->method('withAttribute')
            ->withConsecutive(['validation_errors', []], ['validation_success', true])
            ->willReturnOnConsecutiveCalls($request, $request);
        $validator = new BlogValidator();
        $validator($request, $response , function ($req, $res) {
            $this->assertTrue($req->getAttribute('validation_success'));
        });
    }

    public function test_if_put_request_be_correctly_validated_if_we_provide_invalid_data_in_body_and_valid_file()
    {
        $response = $this->createMock(Response::class);
        $request = $this->createMock(Request::class);
        $file = $this->createMock(UploadedFile::class);
        $route = $this->createMock(Route::class);
        $route->expects($this->once())
            ->method('getArguments')
            ->willReturn(['id' => 1]);
        $file->expects($this->atLeastOnce())
            ->method('getError')
            ->willReturn(UPLOAD_ERR_OK);
        $file->expects($this->once())
            ->method('getClientMediaType')
            ->willReturn('image/png');
        $request->expects($this->exactly(2))
            ->method('getAttribute')
            ->withConsecutive(['route'], ['validation_success', null])
            ->willReturnOnConsecutiveCalls($route, false);
        $request->expects($this->exactly(1))
            ->method('getParams')
            ->willReturn(['title' => 'test', 'content' => 'test content', 'slug' => 'test-slug']);
        $request->expects($this->exactly(1))
            ->method('getUploadedFiles')
            ->willReturn(['blog_image' => $file]);
        $request->expects($this->once())
            ->method('getMethod')
            ->willReturn('PUT');
        //This is the method that tell us if the request is valid or not
        $request->expects($this->atLeast(2))
            ->method('withAttribute')
            ->withConsecutive(['validation_errors', ['Missing required parameters!', 'Unhandled PUT parameter with name: slug']], ['validation_success', false])
            ->willReturnOnConsecutiveCalls($request, $request);
        $validator = new BlogValidator();
        $validator($request, $response , function ($req, $res) {
            $this->assertFalse($req->getAttribute('validation_success'));
        });
    }

    public function test_if_put_request_be_correctly_validated_if_we_provide_valid_data_in_body_and_invalid_file()
    {
        $response = $this->createMock(Response::class);
        $request = $this->createMock(Request::class);
        $file = $this->createMock(UploadedFile::class);
        $route = $this->createMock(Route::class);
        $route->expects($this->once())
            ->method('getArguments')
            ->willReturn(['id' => 1]);
        $file->expects($this->atLeastOnce())
            ->method('getError')
            ->willReturn(UPLOAD_ERR_NO_FILE);
        $request->expects($this->exactly(2))
            ->method('getAttribute')
            ->withConsecutive(['route'], ['validation_success', null])
            ->willReturnOnConsecutiveCalls($route, true);
        $request->expects($this->exactly(1))
            ->method('getParams')
            ->willReturn(['title' => 'test', 'content' => 'test content', '_METHOD' => 'PUT']);
        $request->expects($this->exactly(1))
            ->method('getUploadedFiles')
            ->willReturn(['blog_image' => $file]);
        $request->expects($this->once())
            ->method('getMethod')
            ->willReturn('PUT');
        //This is the method that tell us if the request is valid or not
        $request->expects($this->atLeast(2))
            ->method('withAttribute')
            ->withConsecutive(['validation_errors', []], ['validation_success', true])
            ->willReturnOnConsecutiveCalls($request, $request);
        $validator = new BlogValidator();
        $validator($request, $response , function ($req, $res) {
            $this->assertTrue($req->getAttribute('validation_success'));
        });
    }

    public function test_if_delete_request_be_correctly_validated_if_we_provide_valid_data()
    {
        $response = $this->createMock(Response::class);
        $request = $this->createMock(Request::class);
        $route = $this->createMock(Route::class);
        $route->expects($this->once())
            ->method('getArguments')
            ->willReturn(['id' => 1]);
        $request->expects($this->exactly(2))
            ->method('getAttribute')
            ->withConsecutive(['route'], ['validation_success', null])
            ->willReturnOnConsecutiveCalls($route, true);
        $request->expects($this->once())
            ->method('getMethod')
            ->willReturn('DELETE');
        //This is the method that tell us if the request is valid or not
        $request->expects($this->atLeast(2))
            ->method('withAttribute')
            ->withConsecutive(['validation_errors', []], ['validation_success', true])
            ->willReturnOnConsecutiveCalls($request, $request);
        $validator = new BlogValidator();
        $validator($request, $response , function ($req, $res) {
            $this->assertTrue($req->getAttribute('validation_success'));
        });
    }

    public function test_if_delete_request_be_correctly_validated_if_we_provide_invalid_data()
    {
        $response = $this->createMock(Response::class);
        $request = $this->createMock(Request::class);
        $route = $this->createMock(Route::class);
        $route->expects($this->once())
            ->method('getArguments')
            ->willReturn(['slug' => 1]);
        $request->expects($this->exactly(2))
            ->method('getAttribute')
            ->withConsecutive(['route'], ['validation_success', null])
            ->willReturnOnConsecutiveCalls($route, false);
        $request->expects($this->once())
            ->method('getMethod')
            ->willReturn('DELETE');
        //This is the method that tell us if the request is valid or not
        $request->expects($this->atLeast(2))
            ->method('withAttribute')
            ->withConsecutive(['validation_errors', ['Missing required parameters!', 'Unhandled DELETE parameter with name: slug']], ['validation_success', false])
            ->willReturnOnConsecutiveCalls($request, $request);
        $validator = new BlogValidator();
        $validator($request, $response , function ($req, $res) {
            $this->assertFalse($req->getAttribute('validation_success'));
        });
    }
}
