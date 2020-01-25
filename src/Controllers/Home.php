<?php

namespace Application\Controllers;

use Psr\Http\Message\ServerRequestInterface;
use Vigo\App;

class Home extends App
{
    public function __invoke(ServerRequestInterface $request)
    {
        $template = 'pages::home';
        $dataTemplate = [];
        return $this->htmlResponse($template, $dataTemplate);
    }
}
