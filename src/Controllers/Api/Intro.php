<?php

namespace Application\Controllers\Api;

use Psr\Http\Message\ServerRequestInterface;
use Vigo\App;

class Intro extends App
{
    public function __construct()
    {
        parent::__construct();
    }

    public function __invoke(ServerRequestInterface $request)
    {
        $this->c['template'] = 'api::intro';
        $this->c['dataTemplate'] = [];
        return $this->c['htmlResponse'];

    }
}
