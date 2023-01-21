<?php
// Routes

use Slim\Http\Request;
use Slim\Http\Response;

if (isset($app)) {
    $app->get('/login', function (Request $request, Response $response, array $args = []) {
        return $this->renderer->render($response, 'login.phtml', $args);
    });


    $app->post('/login', function (Request $request, Response $response, array $args = []) {
        $data = $request->getParsedBody();
        $username = $data['username'];
        $password = $data['password'];

        $user = $this->db->fetchAssoc('SELECT * FROM users WHERE username = ?', [$username]);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user;
            return $response->withRedirect('/');
        }

        return $response->withRedirect('/login');
    });
}