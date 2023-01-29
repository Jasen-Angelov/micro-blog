<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Services\AuthManager;
use App\Services\SessionManager;
use Slim\Http\Request;
use Slim\Http\Response;

class LogIn extends BaseController
{
    /**
     * @inheritDoc
     */
    public function get(Request $request, Response $response, array $args = []): Response
    {
        return $this->view->render($response, 'pages/public/login.twig');
    }

    /**
     * @inheritDoc
     */
    public function post(Request $request, Response $response, array $args = []): Response
    {
        $data = $request->getParsedBody();

        if ($request->getAttribute('validation_success') && AuthManager::login_user($data['email'], $data['password'])) {

          return $response->withRedirect('/admin/dashboard');
        }

        return $this->view->render($response, 'pages/public/login.twig', [
            'errors' => ['Invalid email or password!'],
            'data' => $data
        ]);
    }

    /**
     * @inheritDoc
     */
    public function put(Request $request, Response $response, array $args = []): Response
    {
        return $response->withStatus(405);
    }

    /**
     * @inheritDoc
     */
    public function delete(Request $request, Response $response, array $args = []): Response
    {
        AuthManager::logout_current_user();
        SessionManager::destroy_session();

        return $response->withRedirect('/login');
    }
}