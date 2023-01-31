# Micro blog by Yasen Angelov

This is a simple demonstration of a micro-blog application using Slim Framework 3. 

## Install the Application

After you clone the repository, run `composer install` to install all required dependencies.
Make sure that your system matches all requirements for the project.

## Run the Application

* Copy `.env.example` to `.env` and set your database credentials
* Run this command from the project root: `composer run serve`  
* This will start a default PHP server on port 8080. You can now access the application in your browser at the following URL: http://localhost:8080

## Database

* In order to create the necessary tables, run this command from the project root: `composer run db:create`
* In order to seed the database with some dummy data, run this command from the project root: `composer run db:seed` the default user email is `admin@admin.bg` with password `password`

## Tests
* In order to run the tests, run this command from the project root: `composer run test:php`
