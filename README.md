# Basic-RESTful-Slim-PHP-App

Simlpe example of RESTful Slim PHP App
* This app is a backend for JS based app, most of communication implemented by small AJAX requests
* Users management based on HTTP methods with various status code examples
* SQL code for database creation is in `users.sql` file
* GET /users route uses Twig template engine for basic html generating
* GET /api/users route return json with users
* POST /api/user, PUT /api/user/{id}, PATCH /api/user/{id} and DELETE /api/user/{id} routes provides simple but powerful API for managing user database
* Database connection implemented with PDO prepared statements added as dependency to Slim dependencies container
* OPTIONS route is provided and the response is generated by routes object

### Istallation
`composer install` installs the libraries
`PSR-4 autoloader` includes all the lib files
Edit `db_config.php` for your db preferences

### Live example for testing:
[test.bewebmaster.co.il](http://test.bewebmaster.co.il) - _can be some changes in the live version_

### TODO
1. Add interface for basic REST HTTP methods
