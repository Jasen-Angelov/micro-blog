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
        if (isset($args['slug'])) {
            $this->validator->name('slug')->value($args['slug'])->pattern('slug')->is_required();
            if ($this->validator->has_errors()) {
                $this->logger->error('Invalid slug', $this->validator->get_errors());

                return $this->view->render($response, '404.twig');
            }
            $post = BlogPost::where(['slug' => $args['slug']])->first();
            if ($post) {
                return $this->view->render($response, '/pages/public/blog.twig', ['blog' => $post]);
            } else {
                return $this->view->render($response, '404.twig');
            }
        } else {
            $posts = BlogPost::orderBy('created_at', 'desc')->get();
            return  $this->view->render($response, '/pages/public/blog-list.twig', ['blogs' => $posts]);
        }
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