<?php

namespace App\Http;

use \Closure;
use \FFI\Exception;

class Router{

    /**
     * URL completa do projeto (raiz)
     * @var string
     */
    private $url = '';

    /**
     * Prefixo de todas as rotas
     * @var string
     */
    private $prefix = '';

    /**
     * Indice de rotas
     * @var array
     */
    private $routes = [];

    /**
     * Instancia de Request
     * @var Request
     */
    private $request;

    /**
     * Método responsável por iniciar a classe
     * @param string $url
     */
    public function __construct($url) {
        $this->request  = new Request();
        $this->url      = $url;
        $this->setPrefix();
    }

    /**
     * Método responsavel por definir o prefixo das rotas
     */
    private function setPrefix() {
        //Informações da url atual
        $parseUrl = parse_url($this->url);

        //Define o prefixo 
        $this->prefix = $parseUrl['path'] ?? '';
    }

    /**
     * Método repsonsável por adicionar uma rota na classe
     * @param string $method
     * @param string $route 
     * @param array $params
     */
    private function addRoute($method, $route, $params = []) {
        //Validação dos parâmetros
        foreach($params as $key => $value) {
            if($value instanceof Closure) {
                $params['controller'] = $value;
                unset($params[$key]);
                continue;
            }
        }   

        //Padrão de validação da URL
        $patternRoute = '/^'.str_replace('/', '\/', $route ).'$/';


        //Adiciona a rota dentro da classe
        $this->routes[$patternRoute][$method] = $params;

        // echo "<pre>";
        // print_r($this);
        // echo "</pre>";
    }

    /**
     * Método responsável por definir uma rota GET
     * @param string  $route
     * @param array   $params 
     */
    public function get($route, $params = []) {
        $this->addRoute('GET', $route, $params);
    }

    /**
     * Método responsável por retornar a uri desconsiderando o prefixo
     * @return string
     */
    private function getUri() {
        //URI da request
        $uri = $this->request->getUri();

        //Fatia a uri com prefixo
        $xUri = strlen($this->prefix) ? explode($this->prefix, $uri) : [$uri];

        //Retorna a uri sem prefixo
        return end($xUri);

        // echo "<pre>";
        // print_r($xUri);
        // echo "</pre>";
    }

    /**
     * Método responsável por retornar os dados da rota atual
     * @return array
     */
    private function getRoute() {
        //URI
        $uri = $this->getUri();

        echo "<pre>";
        print_r($uri);
        echo "</pre>";
    }

    /**
     * Método responsável por executar a rota atual
     * @return Response
     */
    public function run() {
        try {
            
            //Obtém a rota atual
            $route = $this->getRoute();
            echo "<pre>";
            print_r($route);
            echo "</pre>";

        } catch (Exception $e) {
            return new Response($e->getCode(), $e->getMessage());
        }
    }
}