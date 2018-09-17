<?php

namespace Application\Controllers;

use Psr\Http\Message\ServerRequestInterface;
use Vigo\App;

class Home extends App
{
    public function __construct()
    {
        parent::__construct();
    }

    public function __invoke(ServerRequestInterface $request)
    {
        $this->c['template'] = 'home';
        $this->c['dataTemplate'] = [];
        return $this->c['htmlResponse'];
    }
}
