<?php declare(strict_types = 1);

namespace Vigo;

use Vigo\AppInterface;
use League\Plates\Engine;
use League\Route\Http\Exception\NotFoundException;
use League\Route\Router;
use Pimple\Container;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Diactoros\ServerRequestFactory;
use Zend\HttpHandlerRunner\Emitter\SapiEmitter;
use Zend\Diactoros\ServerRequest;

class App implements AppInterface
{
    protected $c;

    public function __construct()
    {
        $this->c = new Container;
       
        $this->c['plates'] = function (Container $c): Engine {
            $plates = new Engine(__DIR__ . '/../src/templates');
            $plates->addFolder('api', __DIR__ . '/../src/templates/api');
            $plates->setFileExtension('phtml');
            return $plates;
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
        $this->c['htmlResponse'] = function (Container $c): HtmlResponse {
            $htmlContent = $c['plates']->render($c['template'], $c['dataTemplate']);
            return new HtmlResponse($htmlContent);
        };
        $this->c['jsonResponse'] = function (Container $c): JsonResponse {
            return new JsonResponse(
                $c['data'],
                $c['code'],
                ['Content-Type' => ['application/hal+json']]
            );
        };
        $this->c['router'] = function (Container $c): Router {
            return new Router;
        };
        $this->c['send'] = function (Container $c): void {
            try {
                $response = $c['router']->dispatch($c['request']);
            } catch (NotFoundException $e) {
                $path = $c['request']->getUri()->getPath();
                if (\preg_match('/api\/./', $path)) {
                    $c['data'] = ['messaje' => '404: Not found'];
                    $c['code'] = 200;
                    $response  = $c['jsonResponse'];
                } else {
                    $c['template']     = '404';
                    $c['dataTemplate'] = [];
                    $response          = $c['htmlResponse'];
                }
            }
            (new SapiEmitter)->emit($response);
        };
    }

    public function getContainer()
    {
        return $this->c;
    }
}
