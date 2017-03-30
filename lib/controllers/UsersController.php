<?php
namespace Lib\Controllers;

use \Slim\Container as Container;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class UsersController {
    protected $container;
    protected $view;
    protected $db;

    public function __construct(Container $container) {
        $this->container = $container;
        $this->view = $container->get('view');
        $this->db = $container->get('db');
    }
    public function home(Request $request, Response $response) {
        return $response->withRedirect('/users');
    }
    public function showUsers(Request $request, Response $response) {
        $path = 'users';
        $users = $this->getUsers();

        return $this->view->render($response, $path . '.html', [
            'path' => $path,
            'users' => $users,
        ]);
    }
    public function get(Request $request, Response $response) {
        return $response->withJson($this->getUsers());
    }
    public function post(Request $request, Response $response) {
        $path = 'users';
        $body = $request->getParsedBody();

        if ($this->postUser($body['name'], $body['birthdate'])) {
            return $response->withStatus(201);
        } else {
            $response = $response->getBody()->write("{message: adding new user failed}");
            $response = $response->withStatus(422);
            return $response;
        }
    }
    public function put(Request $request, Response $response, $args) {
        $id = (int)filter_var($args['id'], FILTER_SANITIZE_NUMBER_INT);
        $body = $request->getParsedBody();
        $this->putUser($id, $body['name'], $body['birthdate']);
        return $response->withStatus(200);
    }
    public function patch(Request $request, Response $response, $args) {
        $id = (int)filter_var($args['id'], FILTER_SANITIZE_NUMBER_INT);
        $body = $request->getParsedBody();
        $this->patchUser($id, $body['name'], $body['birthdate']);
        return $response->withStatus(200);
    }
    public function delete(Request $request, Response $response, $args) {
        $id = (int)filter_var($args['id'], FILTER_SANITIZE_NUMBER_INT);
        $this->deleteUser($id);
        return $response->withStatus(200);
    }
    public function options(Request $request, Response $response) {
        $routes = $this->container->get('routes');
        $methods = implode(',', array_unique(array_map(function ($route) {
            return $route['method'];
        }, $routes)));
        $response = $response->withHeader('Allow', $methods);
        return $response->withJson($routes);
    }

    private function getUsers () {
        $stmt = $this->db->prepare("SELECT name, birthdate FROM users LIMIT 1000");
        if ($stmt->execute()) {
            $result = $stmt->fetchAll();
        } else { var_dump($this->db->errorInfo()); }
        return $result;
    }
    private function postUser (string $name, string $birthdate) {
        $stmt = $this->db->prepare("INSERT INTO users (name, birthdate) VALUES (:name, :birthdate)");
        $stmt->bindParam(':name', $name, \PDO::PARAM_STR);
        $stmt->bindParam(':birthdate', $birthdate, \PDO::PARAM_STR);
        try {
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            var_dump($this->db->errorInfo());
            return false;
        }
    }
    private function putUser (int $id, string $name, string $birthdate) {
        $stmt = $this->db->prepare("update users set name = :name, birthdate = :birthdate where id = :id");
        $stmt->bindParam(':id', $id, \PDO::PARAM_STR);
        $stmt->bindParam(':name', $name, \PDO::PARAM_STR);
        $stmt->bindParam(':birthdate', $birthdate, \PDO::PARAM_STR);
        try {
            $stmt->execute();
        } catch (PDOException $e) {
            var_dump($this->db->errorInfo());
        }
        return true;
    }
    private function patchUser () {
        $stmt = $this->db->prepare("SELECT name, birthdate FROM users LIMIT 1000");
        if ($stmt->execute()) {
            $result = $stmt->fetchAll();
        } else { var_dump($this->db->errorInfo()); }
        return $result;
    }
    private function deleteUser () {
        $stmt = $this->db->prepare("SELECT name, birthdate FROM users LIMIT 1000");
        if ($stmt->execute()) {
            $result = $stmt->fetchAll();
        } else { var_dump($this->db->errorInfo()); }
        return $result;
    }
}