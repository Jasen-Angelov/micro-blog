<?php
namespace App\Controller;

use Slim\Http\Request;
use Slim\Http\Response;

abstract class BaseController
{
    /**
     * Magic function that allows us to call the class as closure.
     *
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function __invoke(Request $request, Response $response, array $args = []): Response
    {
      switch ($request->getMethod()) {
          case 'GET':
              return $this->get($request, $response, $args);
          case 'POST':
              return $this->post($request, $response);
          case 'PUT':
              return $this->put($request, $response, $args);
          case 'DELETE':
              return $this->delete($request, $response, $args);
          default:
              return $response->withStatus(405);
      }
    }

    /**
     * Get response
     *
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public abstract function get(Request $request, Response $response, array $args = []): Response;

    /**
     * Create a new resource
     *
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public abstract function post(Request $request, Response $response, array $args = []): Response;

    /**
     * Update a resource
     *
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public abstract function put(Request $request, Response $response, array $args = []): Response;

    /**
     * Delete a resource
     *
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public abstract function delete(Request $request, Response $response, array $args = []): Response;

}