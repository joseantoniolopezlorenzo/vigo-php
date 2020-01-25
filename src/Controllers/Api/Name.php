<?php

namespace Application\Controllers\Api;

use Psr\Http\Message\ServerRequestInterface;
use Vigo\App;

class Name extends App
{
    public function __invoke(ServerRequestInterface $request, array $args)
    {
        $name            = $args['name'];
        $data = [
            [
                'autor' => $name,
                'api'   => [
                    'title'   => 'Vigo Simple API v2',
                    'version' => 2,
                ],

            ],
        ];
        $code = 200;
        return $this->jsonResponse($data, $code);
    }
}
