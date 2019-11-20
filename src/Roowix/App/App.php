<?php

namespace Roowix\App;

use Roowix\App\Config\Config;
use Roowix\App\Config\ConfigYamlReader;
use Roowix\App\Response\JsonResponseWriter;
use Roowix\App\Router\Router;
use Roowix\Controller\ControllerInterface;
use Exception;
use Roowix\DB\AuthTokenStorage;
use Throwable;

class App
{
    /** @var Config */
    private $config;
    /** @var DependenciesContainer */
    private $di;
    /** @var Router */
    private $router;
    /** @var JsonResponseWriter */
    private $responseWriter;
    /** @var AuthTokenStorage */
    private $auth;

    public function __construct(string $configPath)
    {
        $this->setExceptionHandlers();

        $this->config = (new ConfigYamlReader())->read($configPath);
        $this->di = new DependenciesContainer($this->config);
        $this->router = new Router($this->config->getRoutes());
        $this->responseWriter = $this->di->get(JsonResponseWriter::class);
        $this->auth = $this->di->get('@auth_token.entity.storage');
    }

    private function setExceptionHandlers()
    {
        register_shutdown_function(function () {
            $error = error_get_last();
            if ($error && $error['type'] === E_ERROR) {
                echo json_encode(['status' => 500, 'message' => $error, 'payload' => []]);
            }
        });

        set_exception_handler(function (Throwable $ex) {
            echo json_encode(['status' => 500, 'message' => $ex->getMessage(), 'payload' => []]);
        });
    }

    /**
     * @param string $method
     * @param string $uri
     * @param array|null $get
     * @param array|null $post
     * @param array|null $headers
     *
     * @throws Exception
     */
    public function run(string $method, string $uri, ?array $get = [], ?array $post = [], ?array $headers = [])
    {
        $route = $this->router->parse($uri);

        /** @var ControllerInterface $controller */
        $controller = $this->di->get($route->getController());
        if (!$controller || !is_a($controller, ControllerInterface::class)) {
            throw new Exception(
                sprintf(
                    "Invalid controller. Uri: %s. Class name: %s",
                    $uri,
                    get_class($controller)
                )
            );
        }

        $request = new Request($method, array_merge($get, $post, $route->getParams()), $headers);

        if (
            $route->requiresAuth()
            && (!$request->hasHeader('Authorization')
                || !$this->auth->validate($request->getHeader('Authorization'), time())
            )
        ) {
            header("HTTP/1.1 401 Unauthorized");
            exit;
        }

        $response = $controller->run($request);

        $this->responseWriter->write($response);
        exit;
    }
}
