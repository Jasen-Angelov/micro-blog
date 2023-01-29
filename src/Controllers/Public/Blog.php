<?php

namespace App\Controllers\Public;

use App\Controllers\BaseController;
use App\Models\Blog as BlogPost;
use Slim\Http\Request;
use Slim\Http\Response;

class Blog extends BaseController
{
    /**
     * @inheritDoc
     */
    public function get(Request $request, Response $response, array $args = []): Response
    {
        if (false === $request->getAttribute('validation_success')){
            return $this->view->render($response, '/pages/404.twig');
        }

        $slug = $args['slug'] ?? null;
        if ($slug) {
            $post = BlogPost::where(['slug' => $slug])->first();
            if ($post) {
                return $this->view->render($response, '/pages/public/blog.twig', ['blog' => $post]);
            } else {
                return $this->view->render($response, '/pages/404.twig');
            }
        }
        $posts = BlogPost::orderBy('created_at', 'desc')->get();

        return  $this->view->render($response, '/pages/public/blog-list.twig', ['blogs' => $posts]);
    }

    /**
     * @inheritDoc
     */
    public function post(Request $request, Response $response, array $args = []): Response
    {
        return $this->view->render($response, '/pages/404.twig');
    }

    /**
     * @inheritDoc
     */
    public function put(Request $request, Response $response, array $args = []): Response
    {
        return $this->view->render($response, '/pages/404.twig');
    }

    /**
     * @inheritDoc
     */
    public function delete(Request $request, Response $response, array $args = []): Response
    {
        return $this->view->render($response, '/pages/404.twig');
    }
}