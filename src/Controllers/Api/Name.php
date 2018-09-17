<?php

namespace Application\Controllers\Api;

use Psr\Http\Message\ServerRequestInterface;
use Vigo\App;

class Name extends App
{
    public function __construct()
    {
        parent::__construct();
    }

    public function __invoke(ServerRequestInterface $request, array $args)
    {
        $name            = $args['name'];
        $this->c['data'] = [
            [
                'autor' => $name,
                'api'   => [
                    'title'   => 'Vigo Simple API v2',
                    'version' => 2,
                ],

            ],
        ];
        $this->c['code'] = 200;
        return $this->c['jsonResponse'];
    }
}
