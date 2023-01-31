<?php

use App\Models\Blog;
use App\Models\Image;
use App\Models\User;
use Dotenv\Dotenv;
use Illuminate\Database\Capsule\Manager;

require 'vendor/autoload.php';
define('APP_ROOT', dirname(__DIR__, 2));
if (file_exists(APP_ROOT . '/.env')) {
    $dotenv = Dotenv::createImmutable(APP_ROOT );
    $dotenv->load();
}
$settings = require 'src/Bootstrap/settings.php';
$capsule = new Manager;
$capsule->addConnection($settings['settings']['db']);
$capsule->setAsGlobal();
$capsule->bootEloquent();

$faker = Faker\Factory::create();

$user = new User();
$user->name  = $_ENV['ADMIN_NAME'] ?? 'admin';
$user->email = $_ENV['ADMIN_EMAIL'] ?? 'admin@admin.bg';
$user->password = password_hash('admin', PASSWORD_DEFAULT);
$user->save();


for ($i = 0; $i < 10; $i++) {
    $post = new Blog();
    $post->title = $faker->realText(20);
    $post->content = $faker->realText(500);
    $post->slug = $faker->slug;
    $post->user_id = $user->id;
    $post->image_id = $i;
    $post->save();
}

for ($i = 0; $i < 10; $i++) {
    $image = new Image();
    $image->name = $faker->name;
    $image->path = $faker->imageUrl();
    $image->save();
}