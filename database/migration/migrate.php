<?php

use Dotenv\Dotenv;
use Illuminate\Database\Capsule\Manager;
use Illuminate\Database\Schema\Blueprint;

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

Manager::schema()->create('users', function (Blueprint $table) {
    $table->increments('id');
    $table->string('name', 50);
    $table->string('email', 50);
    $table->string('password', 256);
    $table->timestamps();
    $table->unique('email');
});

Manager::schema()->create('blogs', function (Blueprint $table) {
    $table->increments('id');
    $table->string('title', 256);
    $table->text('content');
    $table->string('slug', 256);
    $table->integer('user_id');
    $table->integer('image_id');
    $table->timestamps();
    $table->unique('slug');
});

Manager::schema()->create('images', function (Blueprint $table) {
    $table->increments('id');
    $table->string('name');
    $table->string('path');
    $table->timestamps();
    $table->unique('path');
});