<?php

use Illuminate\Database\Capsule\Manager;

require 'vendor/autoload.php';

define('APP_ROOT', dirname(__DIR__));
$settings = require 'src/Bootstrap/settings.php';
$capsule = new Manager;
$capsule->addConnection($settings['settings']['db']);
$capsule->setAsGlobal();
$capsule->bootEloquent();

Manager::schema()->create('users', function ($table) {
    $table->increments('id');
    $table->string('name');
    $table->string('email')->unique();
    $table->string('password');
    $table->rememberToken();
    $table->timestamps();
});

Manager::schema()->create('blogs', function ($table) {
    $table->increments('id');
    $table->string('title')->varchar(256);
    $table->text('content')->varchar(500);
    $table->string('slug')->unique();
    $table->integer('user_id')->unsigned();
    $table->integer('image_id')->unsigned();
    $table->timestamps();
});

Manager::schema()->create('images', function ($table) {
    $table->increments('id');
    $table->string('name');
    $table->string('path');
    $table->timestamps();
});

$faker = Faker\Factory::create();

$user = new \App\Models\User();
$user->name = 'test';
$user->email = 'admin@admin.bg';
$user->password = password_hash('admin', PASSWORD_DEFAULT);
$user->save();

for ($i = 0; $i < 9; $i++) {
    $user = new \App\Models\User();
    $user->name = $faker->name;
    $user->email = $faker->email;
    $user->password = password_hash('password', PASSWORD_DEFAULT);
    $user->save();
}

for ($i = 0; $i < 10; $i++) {
    $post = new \App\Models\Blog();
    $post->title = $faker->realText(20);
    $post->content = $faker->realText(500);
    $post->slug = $faker->slug;
    $post->user_id = $faker->numberBetween(1, 10);
    $post->image_id = $faker->numberBetween(1, 10);
    $post->save();
}

for ($i = 0; $i < 10; $i++) {
    $image = new \App\Models\Image();
    $image->name = $faker->name;
    $image->path = $faker->imageUrl();
    $image->save();
}