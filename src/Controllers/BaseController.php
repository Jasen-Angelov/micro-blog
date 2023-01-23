<?php
namespace App\Controllers;

use App\Interfaces\Controller;
use App\Interfaces\Validator;
use Monolog\Logger;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Views\Twig;

abstract class BaseController implements Controller
{

    /**
     * This function will add the App to the controller.
     *
     * @param Twig $view
     * @param Logger $logger
     * @param Validator $validator
     */
    public function __construct(protected Twig $view, protected Logger $logger, protected Validator $validator)
    {
    }
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
        return match ($request->getMethod()) {
            'GET'    => $this->get($request, $response, $args),
            'POST'   => $this->post($request, $response),
            'PUT'    => $this->put($request, $response, $args),
            'DELETE' => $this->delete($request, $response, $args),
            default  => $response->withStatus(405),
        };
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