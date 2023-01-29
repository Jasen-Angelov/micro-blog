<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Services\AuthManager;
use Slim\Http\Request;
use Slim\Http\Response;

class Admin extends BaseController
{

    /**
     * This method is called when the user visits the admin panel.
     *
     * @inheritDoc
     */
    public function get(Request $request, Response $response, array $args = []): Response
    {
        $posts = \App\Models\Blog::where('user_id', AuthManager::get_authenticated_user_id())->get();
        return $this->view->render($response, 'pages/admin/admin-panel.twig', [
            'posts' => $posts
        ]);
    }

    /**
     * @inheritDoc
     */
    public function post(Request $request, Response $response, array $args = []): Response
    {
        return $response->withStatus(405);
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
        return $response->withStatus(405);
    }
}