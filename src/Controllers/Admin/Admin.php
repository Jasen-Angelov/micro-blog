<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use Slim\Http\Request;
use Slim\Http\Response;

class Admin extends BaseController
{

    /**
     * @inheritDoc
     */
    public function get(Request $request, Response $response, array $args = []): Response
    {
        $posts = \App\Models\Blog::where('user_id', $_SESSION['user']['id'])->get();
        return $this->view->render($response, 'pages/admin/admin-panel.twig', [
            'posts' => $posts
        ]);
    }

    /**
     * @inheritDoc
     */
    public function post(Request $request, Response $response, array $args = []): Response
    {
        // TODO: Implement post() method.
    }

    /**
     * @inheritDoc
     */
    public function put(Request $request, Response $response, array $args = []): Response
    {
        // TODO: Implement put() method.
    }

    /**
     * @inheritDoc
     */
    public function delete(Request $request, Response $response, array $args = []): Response
    {
        // TODO: Implement delete() method.
    }
}