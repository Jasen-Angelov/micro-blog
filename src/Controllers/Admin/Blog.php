<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Blog as BlogPost;
use App\Services\AuthManager;
use App\Services\BlogManager;
use App\Services\ImageManager;
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
            $blog = BlogPost::where('id', $args['id'])->where('user_id', AuthManager::get_authenticated_user_id())->first();
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
                'title'    => htmlentities($data['title']),
                'content'  => htmlentities($data['content']),
                'user_id'  => AuthManager::get_authenticated_user_id(),
                'image_id' => $image->id,
            ];
            if (BlogManager::upsert_blog($data)) {
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

        $blog = BlogPost::where('id', $args['id'])->where('user_id', AuthManager::get_authenticated_user_id())->first();

        if ($blog) {
            $image = null;
            if ($file->file) {
                $image = ImageManager::create_image_from_file($file);
                ImageManager::delete_existing_images($blog->image);
            }
            $data = [
                'title' => htmlentities($data['title']),
                'content' => htmlentities($data['content']),
                'user_id' => AuthManager::get_authenticated_user_id(),
                'image_id' => $image->id ?? $blog->image_id
            ];

            $result = BlogManager::upsert_blog($data, $blog);
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
        if ($request->getAttribute('validation_success') && BlogManager::delete_blog($args['id'])) {
            $this->flash->addMessage('success', "Blog successfully deleted!");
        } else {
            $this->flash->addMessage('danger', "Blog could not be deleted!");
        }

        return $response->withRedirect('/admin/dashboard');
    }

}