<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use Slim\Http\Request;
use Slim\Http\Response;
Use App\Models\User as Admin;

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
        $this->validator->name('email')->value($data['email'])->is_email();
        $this->validator->name('password')->value($data['password'])->pattern('alphanumeric')->is_required();
        if ($this->validator->is_valid()) {
            $email = filter_var($data['email'], FILTER_SANITIZE_EMAIL);
            $password = $data['password'];
            $user = Admin::where('email', $email)->first();
            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user'] = $user;
                return $response->withRedirect('/admin/dashboard');
            }
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
        unset($_SESSION['user']);
        return $response->withRedirect('/login');
    }
}