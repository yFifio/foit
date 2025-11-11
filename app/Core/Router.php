<?php
// Salve em: app/Core/Router.php

class Router
{
    protected array $routes = [
        'GET' => [],
        'POST' => []
    ];

    /**
     * Carrega as definições de rotas de um arquivo.
     */
    public static function load(string $file): self
    {
        $router = new self;
        require $file;
        return $router;
    }

    /**
     * Define uma rota GET.
     */
    public function get(string $uri, string $controllerAction): void
    {
        $this->addRoute('GET', $uri, $controllerAction);
    }

    /**
     * Define uma rota POST.
     */
    public function post(string $uri, string $controllerAction): void
    {
        $this->addRoute('POST', $uri, $controllerAction);
    }

    /**
     * Adiciona a rota ao array.
     */
    private function addRoute(string $method, string $uri, string $controllerAction): void
    {
        $this->routes[$method][$uri] = $controllerAction;
    }

    /**
     * Encontra e executa a rota correspondente.
     */
    public function handle(string $uri, string $method): mixed
    {
        // Limpa a query string da URI
        $uri = strtok($uri, '?');
        
        // Remove o BASE_PATH da URI
        $basePath = BASE_PATH;
        if ($basePath !== '' && strpos($uri, $basePath) === 0) {
            $uri = substr($uri, strlen($basePath));
        }
        $uri = $uri === '' ? '/' : $uri;

        // Tenta encontrar uma rota literal
        if (array_key_exists($uri, $this->routes[$method])) {
            return $this->callAction(...explode('@', $this->routes[$method][$uri]));
        }

        // Tenta encontrar uma rota com parâmetros (ex: /product/123)
        foreach ($this->routes[$method] as $route => $action) {
            // Converte a rota para regex (ex: /product/{id} -> /product/(\d+))
            $regex = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<$1>[^/]+)', $route);
            $regex = '#^' . $regex . '$#';

            if (preg_match($regex, $uri, $matches)) {
                // Coloca os parâmetros da URL (ex: id=123) em $_GET
                foreach ($matches as $key => $value) {
                    if (is_string($key)) {
                        $_GET[$key] = $value;
                    }
                }
                return $this->callAction(...explode('@', $action));
            }
        }
        
        // Rota não encontrada
        http_response_code(404);
        echo "Erro 404 - Página não encontrada";
        exit;
    }

    /**
     * Chama o método do controller.
     */
    protected function callAction(string $controller, string $method): mixed
    {
        // Inclui o controller
        $controllerFile = __DIR__ . "/../Controllers/{$controller}.php";
        if (!file_exists($controllerFile)) {
            throw new Exception("Controller {$controller} não encontrado.");
        }
        require_once $controllerFile;
        
        $controllerInstance = new $controller();

        if (!method_exists($controllerInstance, $method)) {
            throw new Exception("Método {$method} não existe no controller {$controller}.");
        }

        return $controllerInstance->$method();
    }
}