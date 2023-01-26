<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Helpers\ImageManager;
use App\Models\Blog as BlogPost;
use App\Services\BlogManager;
use Slim\Http\Request;
use Slim\Http\Response;

class Blog extends BaseController
{

    /**
     * @inheritDoc
     */
    public function get(Request $request, Response $response, array $args = []): Response
    {
        $blog = null;
        if ($request->getAttribute('validation_success')) {
            $blog = BlogPost::where('id', $args['id'])->where('user_id', $_SESSION['user']['id'])->first();
        }

        return $this->view->render($response, '/pages/admin/edit-blog.twig', ['blog' => $blog]);
    }

    /**
     * @inheritDoc
     */
    public function post(Request $request, Response $response, array $args = []): Response
    {
        $data = $request->getParams();
        $file = $request->getUploadedFiles()['blog_image'];
        if ($request->getAttribute('validation_success')) {
            $image = ImageManager::create_image_from_file($file);
            $data = [
                'title' => htmlentities($data['title']),
                'content' => htmlentities($data['content']),
                'user_id' => $_SESSION['user']['id'],
            ];
            if (BlogManager::upsert_blog($data, ['image' => $image])) {
                $this->flash->addMessage('success', "Blog successfully created!");
            } else {
                ImageManager::delete_existing_images($image);
                $this->logger->error('Blog creation failed!');
                $this->flash->addMessage('danger', "Blog creation failed!");
            }
        }else{
            foreach ($request->getAttribute('validation_errors') as $error) {
                $this->flash->addMessage('danger', $error);
            }
        }

        return $response->withRedirect('/admin/dashboard');
    }

    /**
     * @inheritDoc
     */
    public function put(Request $request, Response $response, array $args = []): Response
    {
        $msg_type = 'danger';
        $msg = 'You are not allowed to do this!';

        $data = $request->getParams();
        $file = $request->getUploadedFiles()['blog_image'];

        if (false === $request->getAttribute('validation_success')) {
            foreach ($request->getAttribute('validation_errors') as $error) {
                $this->flash->addMessage($msg_type, $error);
            }

            return $response->withRedirect($request->getUri());
        }

        $blog = BlogPost::where('id', $args['id'])->where('user_id', $_SESSION['user']['id'])->first();

        if ($blog) {
            if ($file->file) {
                $image = ImageManager::create_image_from_file($file);
                ImageManager::delete_existing_images($blog->image);
                $blog->image()->save($image);
            }
            $data = [
                'title' => htmlentities($data['title']),
                'content' => htmlentities($data['content']),
                'user_id' => $_SESSION['user']['id'],
            ];

            $result = BlogManager::upsert_blog($data);
            $msg_type = $result ? 'success' : 'danger';
            $msg = $result ? 'Blog successfully updated!' : 'Blog failed to be updated!';
        }

        $this->flash->addMessage($msg_type, $msg);

        return $response->withRedirect($request->getUri());
    }

    /**
     * @inheritDoc
     */
    public function delete(Request $request, Response $response, array $args = []): Response
    {
        $this->validator->name('id')->value($args['id'])->is_int();
        if ($this->validator->is_valid() && $blog = BlogPost::where('id', $args['id'])->where('user_id', $_SESSION['user']['id'])) {
            $blog->delete();
            $this->flash->addMessage('success', "Blog successfully deleted!");
        } else {
            foreach ($this->validator->get_errors() as $error) {
                $this->flash->addMessage('danger', $error);
            }
        }

        return $response->withRedirect('/admin/dashboard');
    }

}