<?php

namespace Application\Controllers\Api;

use Psr\Http\Message\ServerRequestInterface;
use Vigo\App;

class Intro extends App
{
    
    public function __invoke(ServerRequestInterface $request)
    {
        $template = 'api::intro';
        $dataTemplate = [];
        return $this->htmlResponse($template, $dataTemplate);

    }
}
