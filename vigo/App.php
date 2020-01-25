<?php declare(strict_types = 1);

namespace Vigo;

use Pimple\Container;
use League\Plates\Engine;
use League\Route\Router;
use League\Route\Http\Exception\NotFoundException;
use Zend\Diactoros\ServerRequestFactory;
use Zend\Diactoros\ServerRequest;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\JsonResponse;
use Zend\HttpHandlerRunner\Emitter\SapiEmitter;

class App
{
    public $c;

    public function __construct()
    {
        $this->c = new Container;
        $this->c['plates'] = function (Container $c): Engine {
            $plates = new Engine(DIR_VIEWS);
            $plates->addFolder('pages', DIR_VIEWS . '/pages');
            $plates->addFolder('api', DIR_VIEWS . '/api');
            $plates->setFileExtension('phtml');
            return $plates;
        };
        $this->c['db'] = function (Container $c) {
            $dns = "sqlite:". DB;
            return new \PDO($dns);
        };
        $this->c['request'] = function (Container $c): ServerRequest {
            return ServerRequestFactory::fromGlobals(
                $_SERVER,
                $_GET,
                $_POST,
                $_COOKIE,
                $_FILES
            );
        };
        $this->c['router'] = function (Container $c): Router {
            return new Router;
        };
    }

    public function router()
    {
        return $this->c['router'];
    }

    protected function htmlResponse($template, $dataTemplate): HtmlResponse
    {
        $htmlContent = $this->c['plates']->render($template, $dataTemplate);
        return new HtmlResponse($htmlContent);
    }

    protected function jsonResponse($data, $code): JsonResponse
    {
        return new JsonResponse(
            $data,
            $code,
            ['Content-Type' => ['application/hal+json']]
        );
    }

    public function sendResponse()
    {
        try {
            $response = $this->c['router']->dispatch($this->c['request']);
        } catch (NotFoundException $e) {
            $path = $this->c['request']->getUri()->getPath();
            if (\preg_match('/api\/./', $path)) {
                $data = ['messaje' => '404: Not found'];
                $code = 404;
                $response  = $this->jsonResponse($data, $code);
            } else {
                $template     = 'pages::404';
                $dataTemplate = [];
                $response          = $this->htmlResponse($template, $dataTemplate);
            }
        }
        (new SapiEmitter)->emit($response);
    }
}
