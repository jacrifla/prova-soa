<?php

require_once 'Request.php';
require_once 'Response.php';

class Core{
    public static function dispatch(array $routes){
        $route_exists = false;
        $url = '/';

        isset($_GET['url']) && $url .= $_GET['url']; //programação funcional verifica se tem o parametro url e concatena no $url o valor que veio preenchido

        $url != '/' && $url = rtrim($url, '/'); // garante que se a url tiver vazia nao tem espaços em branco

        foreach ($routes as $route){
            $regex = '#^' . preg_replace('/{id}/', '([\w-]+)', $route['path']) . '$#';//substitui pelo numero passado na url, desde que exista esse parametro

            if(preg_match($regex, $url, $matches)){ // passa um regex, uma string que quer q analise e o terceiro se encontrar alguam coisa que faz match ele retorna nessa avriavel
                $route_exists = true;
                array_shift($matches);

                if($route['method'] != Request::method()) {
                    Response::json([
                        'status' => 'error',
                        'message' => 'method não aceito'
                    ], 405);
                    return;
                }
            
            [$controller, $action] = explode('@', $route['action']);//separa o pelo @ as duas strings em duas variaveis

            require_once "./controller/$controller.php";//deixa de forma dinamica require de todas as classes criadas na pasta controller
            
            if(!class_exists($controller)){
                Response::json([
                    'status' => 'error',
                    'message' => "class [$controller] não existe."
                ], 500);
                return;
            }

            $controller = new $controller();

            if(!method_exists($controller, $action)){
                Response::json([
                    'status' => 'error',
                    'message' => "action [$action] não existe."
                ], 500);
                return;
            }

            $controller->$action(new Request, new Response, $matches);
        }
        }

        if(!$route_exists){
            Response::json([
                'status' => 'error',
                'message' => "rota não existe."
            ], 404);
            return;
        }

    }
}